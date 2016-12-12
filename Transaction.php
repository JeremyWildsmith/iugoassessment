<?php

use IugoGameLib\SuccessDocumentFactory;
use IugoGameLib\Transaction\DocumentTransactionDAO;
use IugoGameLib\Transaction\PdoTransactionDAO;

class Transaction extends JsonEndpoint {

    const VALIDATION_KEY = "NwvprhfBkGuPJnjJp77UPJWJUpgC7mLz";

    protected function generateResults($input) {

        $inputTransaction = (new DocumentTransactionDAO($input))->get();

        $pdo = (new PdoFactory())->create();
        $dao = new PdoTransactionDAO($pdo, Transaction::VALIDATION_KEY);

        $dao->update($inputTransaction);
        $dao->save();

        return (new SuccessDocumentFactory())->create();
    }

}
