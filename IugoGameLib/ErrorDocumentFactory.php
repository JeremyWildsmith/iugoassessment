<?php
namespace IugoGameLib;

use IugoGameLib\Document\DocumentNode;

final class ErrorDocumentFactory { 
    public function create($reason) {
        $node = new DocumentNode();
        $node->addChild(new DocumentNode("Error", true));
        $node->addChild(new DocumentNode("ErrorMessage", $reason));
        return $node;
    }
}