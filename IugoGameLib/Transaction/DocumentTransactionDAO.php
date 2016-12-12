<?php
namespace IugoGameLib\Transaction;

use IugoGameLib\Document\NoSuchChildNodeException;
use IugoGameLib\Document\ImproperDocumentFormException;
use IugoGameLib\Transaction\ImmutableTransactionDAO;
use IugoGameLib\Transaction\TransactionVO;

final class DocumentTransactionDAO implements ImmutableTransactionDAO {
    private $transactionVo;
    
    public function __construct($documentNode) {
        try {
            $transactionId = $documentNode->getChild("TransactionId")->getValue();
            $userId = $documentNode->getChild("UserId")->getValue();
            $currencyAmount = $documentNode->getChild("CurrencyAmount")->getValue();
            $verifier = $documentNode->getChild("Verifier")->getValue();
            
            if(!is_int($transactionId) || !is_int($userId) || !is_int($currencyAmount))
                throw new ImproperDocumentFormException("Data provided is not valid");
            
            $this->transactionVo = new TransactionVO($userId, $currencyAmount, $transactionId, $verifier);
        } catch (NoSuchChildNodeException $e) {
            throw new ImproperDocumentFormException("Document form is invalid.", $e);
        }
    }
    
    public function get() {
        return $this->transactionVo;
    }

    public function getAll() {
        return [$this->transactionVo];
    }

    public function getWith($userId) {
        if($this->transactionVo->getUserId() === $userId) {
            return [$this->transactionVo];
        }
        
        return [];
    }
}
