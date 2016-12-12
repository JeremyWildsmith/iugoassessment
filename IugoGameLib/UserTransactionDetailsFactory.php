<?php
namespace IugoGameLib;

use IugoGameLib\Document\DocumentNode;

final class UserTransactionDetailsFactory { 
    public function create($stats) {
        $node = new DocumentNode();
        $node->addChild(new DocumentNode("UserId", $stats->getUserId()));
        $node->addChild(new DocumentNode("TransactionCount", $stats->getTransactionCount()));
        $node->addChild(new DocumentNode("CurrencySum", $stats->getCurrencySum()));
        return $node;
    }
}