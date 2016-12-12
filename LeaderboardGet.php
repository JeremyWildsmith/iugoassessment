<?php
use IugoGameLib\Leaderboard\DocumentLeaderboardGetDAO;
use IugoGameLib\Leaderboard\PdoLeaderboardStatsDAO;
use IugoGameLib\LeaderboardGetDocumentFactory;

class LeaderboardGet extends JsonEndpoint {    
    protected function generateResults($document) {
        
        $leaderboardRequest = (new DocumentLeaderboardGetDAO($document))->get();
        
        $pdo = (new PdoFactory())->create();
        $statsDao = new PdoLeaderboardStatsDAO($pdo);
        $userStats = $statsDao->getWith($leaderboardRequest->getUserId(), $leaderboardRequest->getLeaderboardId());

        if ($userStats === null) {
            $this->error("No score data for the specified user id in the specified leadboard.");
        }

        $statsSet = $statsDao->getRange($leaderboardRequest->getLeaderboardId(), $leaderboardRequest->getOffset(), $leaderboardRequest->getLimit());
        $leaderboardDocumentFactory = new LeaderboardGetDocumentFactory();

        return $leaderboardDocumentFactory->create($userStats, $statsSet);
    }
}