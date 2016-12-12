<?php

namespace IugoGameLib\Transaction;

use IugoGameLib\Transaction\TransactionDAO;
use IugoGameLib\Transaction\TransactionVO;
use IugoGameLib\Transaction\TransactionValidationException;

final class PdoTransactionDAO implements TransactionDAO {

    const INTEGRITY_CONSTRAINT_VIOLATION = "23000";

    private $pdo;
    private $update = array();
    private $delete = array();
    private $stmtGetAll;
    private $stmtGetWith;
    private $stmtGetWithTransactionId;
    private $stmtDelete;
    private $stmtInsert;
    private $stmtUpdate;
    private $validationKey;

    public function __construct($pdo, $validationKey = '') {
        $this->pdo = $pdo;
        $this->stmtGetAll = $pdo->prepare('SELECT transactionId, userId, currencyAmount ' .
                'FROM transaction');

        $this->stmtGetWith = $pdo->prepare('SELECT transactionId, userId, currencyAmount ' .
                'FROM transaction ' .
                'WHERE userId=?');

        $this->stmtGetWithTransactionId = $pdo->prepare('SELECT transactionId, userId, currencyAmount ' .
                'FROM transaction ' .
                'WHERE transactionId=?');

        $this->stmtDelete = $pdo->prepare('DELETE FROM transaction ' .
                'WHERE transactionId=?');

        $this->stmtInsert = $pdo->prepare('INSERT INTO transaction (transactionId, userId, currencyAmount) ' .
                'VALUES(?, ?, ?)');

        $this->stmtUpdate = $pdo->prepare('UPDATE transaction SET userId=?, currencyAmount=? ' .
                'WHERE transactionId=?');

        $this->validationKey = $validationKey;
    }

    private function calculateSha1($transaction) {
        $value = $this->validationKey . $transaction->getId() . $transaction->getUserId() . $transaction->getCurrencyAmount();
        return sha1($value);
    }

    private function isTransactionValid($transaction) {
        $hash = $this->calculateSha1($transaction);

        if (strcasecmp($transaction->getVerifier(), $hash) !== 0) {
            return false;
        }
        
        return true;
    }

    public function delete($transaction) {
        array_push($this->delete, $transaction);
    }

    public function getAll() {
        $vos = array();

        $this->stmtGetAll->execute();
        while (($res = $this->stmtGetAll->fetch(\PDO::FETCH_ASSOC)) !== false) {
            array_push($vos, new TransactionVO($res['userId'], $res['currencyAmount'], $res['transactionId']));
        }

        return $vos;
    }

    public function getWith($userId) {
        $vos = array();

        $this->stmtGetWith->execute([$userId]);
        while (($res = $this->stmtGetWith->fetch(\PDO::FETCH_ASSOC)) !== false) {
            array_push($vos, new TransactionVO($res['userId'], $res['currencyAmount'], $res['transactionId']));
        }

        return $vos;
    }

    public function save() {
        foreach ($this->update as $u) {
            if (!$this->isTransactionValid($u)) {
                throw new TransactionValidationException("Validifier is incorrect.", $u);
            }

            try {
                $this->stmtInsert->execute([$u->getId(), $u->getUserId(), $u->getCurrencyAmount()]);
            } catch (\PDOException $e) {
                if ($e->errorInfo[0] === PdoTransactionDAO::INTEGRITY_CONSTRAINT_VIOLATION) {
                    throw new TransactionValidationException("Duplicate transaction cannot be accepted.", $u);
                } else {
                    throw $e;
                }
            }
        }

        foreach ($this->delete as $d) {
            if ($u->getId() !== null) {
                $this->stmtDelete->execute([$d->getId()]);
            }
        }

        $this->update = array();
        $this->delete = array();
    }

    public function update($transaction) {
        array_push($this->update, $transaction);
    }

}
