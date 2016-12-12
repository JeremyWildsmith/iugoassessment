<?php
namespace IugoGameLib;

use IugoGameLib\Document\DocumentNode;

final class TimestampDocumentFactory { 
    public function create($time = -1) {
        $node = new DocumentNode();
        $node->addChild(new DocumentNode("Timestamp", $time < 0 ? time() : $time));
        return $node;
    }
}