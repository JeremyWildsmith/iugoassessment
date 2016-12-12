<?php

namespace IugoGameLib\Leaderboard;

class LeaderboardStatsVO extends ScoreVO {
    private $rank;
    
    public function __construct($userId, $leaderboardId, $score, $scoreId, $rank) {
        parent::__construct($userId, $leaderboardId, $score, $scoreId);
        $this->rank = $rank;
    }

    public function getRank() {
        return $this->rank;
    }
}
