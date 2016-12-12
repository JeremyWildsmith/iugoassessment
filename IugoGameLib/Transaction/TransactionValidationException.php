<?php
namespace IugoGameLib\Transaction;

use IugoGameLib\IugoException;

class TransactionValidationException extends IugoException {
    private $offendingTransaction;
    
    public function __construct($reason, $offendingTransaction) {
        parent::__construct($reason);
        
        $this->offendingTransaction = $offendingTransaction;
    }
    
    public function getOffendingTransaction() {
        return $this->offendingTransaction;
    }
}
