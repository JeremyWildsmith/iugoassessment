<?php

namespace IugoGameLib;

use IugoGameLib\Document\DocumentNode;

final class LeaderboardGetDocumentFactory {
    
    private function createNodeWithStats($stats) {
        $node = new DocumentNode();
        
        $node->addChild(new DocumentNode("UserId", $stats->getUserId()));
        $node->addChild(new DocumentNode("Score", $stats->getScore()));
        $node->addChild(new DocumentNode("Rank", $stats->getRank()));
    
        return $node;
    }
    
    public function create($queryUserStats, $statsSet = null) {
        $node = $this->createNodeWithStats($queryUserStats);
        $node->addChild(new DocumentNode("LeaderboardId", $queryUserStats->getLeaderboardId()));
        
        if($statsSet !== null) {
            $entries = $node->addChild(new DocumentNode("Entries"));
            $statNodes = array();
            foreach ($statsSet as $s) {
                array_push($statNodes, $this->createNodeWithStats($s));
            }

            $entries->setValue($statNodes);
        }
        return $node;
    }
}
