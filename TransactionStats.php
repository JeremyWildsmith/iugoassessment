<?php

use IugoGameLib\Transaction\PdoTransactionStatsDAO;
use IugoGameLib\User\DocumentUserInfoDAO;
use IugoGameLib\UserTransactionDetailsFactory;

class TransactionStats extends JsonEndpoint {

    protected function generateResults($input) {
        $userId = (new DocumentUserInfoDAO($input))->get()->getUserId();

        $pdo = (new PdoFactory())->create();
        $dao = new PdoTransactionStatsDAO($pdo);

        $stats = $dao->getWith($userId);

        if ($stats === null) {
            $this->error("No transactions recorded for specified user.");
        }

        return (new UserTransactionDetailsFactory())->create($stats);
    }

}