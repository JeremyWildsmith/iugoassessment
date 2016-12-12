<?php

namespace IugoGameLib\Transaction;

use IugoGameLib\Transaction\TransactionStatsDAO;
use IugoGameLib\Transaction\TransactionStatsVO;

class PdoTransactionStatsDAO implements TransactionStatsDAO {

    private $pdo;
    private $stmtGet;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->stmtGet = $pdo->prepare('SELECT userId, COUNT(*) AS num, SUM(currencyAmount) AS total ' .
                                 'FROM transaction '.
                                 'WHERE userId = ? ' .
                                 'GROUP BY userId');
    }
    
    public function getWith($userId) {
        $this->stmtGet->execute([$userId]);
        
        $result = $this->stmtGet->fetch(\PDO::FETCH_ASSOC);
        
        if($result === false) {
            return null;
        }
        
        return new TransactionStatsVO($result['userId'], $result['num'], (int)$result['total']);
    }
}
