<?php
namespace IugoGameLib;

use IugoGameLib\Document\DocumentNode;

final class SuccessDocumentFactory { 
    public function create($isSuccess = true) {
        $node = new DocumentNode();
        $node->addChild(new DocumentNode("Success", $isSuccess));
        return $node;
    }
}