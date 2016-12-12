<?php

namespace IugoGameLib\Leaderboard;

interface LeaderboardStatsDAO {
    public function getWith($userId, $leaderboardId);
    public function getRange($leaderboardId, $offset, $limit);
}
