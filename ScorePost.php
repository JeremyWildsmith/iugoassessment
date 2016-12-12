<?php
use IugoGameLib\Leaderboard\DocumentScoreDAO;
use IugoGameLib\Leaderboard\PdoLeaderboardStatsDAO;
use IugoGameLib\Leaderboard\PdoScoreDAO;
use IugoGameLib\LeaderboardGetDocumentFactory;

class ScorePost extends JsonEndpoint {

    protected function generateResults($input) {
        $inputScore = (new DocumentScoreDAO($input))->get();

        $pdo = (new PdoFactory())->create();
        $statsDao = new PdoLeaderboardStatsDAO($pdo);
        $scoreDao = new PdoScoreDAO($pdo);

        $currentScore = $statsDao->getWith($inputScore->getUserId(), $inputScore->getLeaderboardId());

        if ($currentScore === null) {
            $scoreDao->update($inputScore);
            $scoreDao->save();
            $currentScore = $statsDao->getWith($inputScore->getUserId(), $inputScore->getLeaderboardId());
        } else if ($inputScore->getScore() > $currentScore->getScore()) {
            $currentScore->setScore($inputScore->getScore());
            $scoreDao->update($currentScore);
            $scoreDao->save();
            $currentScore = $statsDao->getWith($inputScore->getUserId(), $inputScore->getLeaderboardId());
        }

        $leaderboardDocumentFactory = new LeaderboardGetDocumentFactory();
        return $leaderboardDocumentFactory->create($currentScore);
    }
}