<?php
namespace IugoGameLib\Transaction;

final class TransactionVO {
    private $transactionId;
    private $userId;
    private $currencyAmount;
    private $verifier;
    
    public function __construct($userId, $currencyAmount, $transactionId = null, $verifier = null) {
        $this->userId = $userId;
        $this->currencyAmount = $currencyAmount;
        $this->transactionId = $transactionId;
        $this->verifier = $verifier;
    }
    
    public function getId() {
        return $this->transactionId;
    }
    
    public function getVerifier() {
        return $this->verifier;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getCurrencyAmount() {
        return $this->currencyAmount;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setCurrencyAmount($currencyAmount) {
        $this->currencyAmount = $currencyAmount;
    }
}