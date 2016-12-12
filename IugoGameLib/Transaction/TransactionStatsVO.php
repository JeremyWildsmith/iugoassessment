<?php

namespace IugoGameLib\Transaction;

class TransactionStatsVO {
    private $userId;
    private $transactionCount;
    private $currencySum;
    
    public function __construct($userId, $transactionCount, $currencySum) {
        $this->userId = $userId;
        $this->transactionCount = $transactionCount;
        $this->currencySum = $currencySum;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getTransactionCount() {
        return $this->transactionCount;
    }

    public function getCurrencySum() {
        return $this->currencySum;
    }
}
