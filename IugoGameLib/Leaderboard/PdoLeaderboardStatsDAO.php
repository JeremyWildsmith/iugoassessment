<?php

namespace IugoGameLib\Leaderboard;

use IugoGameLib\Leaderboard\LeaderboardStatsDAO;
use IugoGameLib\Leaderboard\LeaderboardStatsVO;

class PdoLeaderboardStatsDAO implements LeaderboardStatsDAO {

    private $pdo;
    private $stmtGet;
    private $stmtGetRange;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->stmtGet = $pdo->prepare('SELECT * ' .
                                        'FROM (' .
                                            'SELECT scoreId, userId, leaderboardId, score, @i:=@i+1 AS rank ' .
                                            'FROM score ' .
                                                'JOIN (SELECT @i:=0) exp ' .
                                            'WHERE leaderboardId = ? ' .
                                            'ORDER BY score DESC' .
                                        ') r ' .
                                        'WHERE r.userId = ?');
        
        $this->stmtGetRange = $pdo->prepare('SELECT * ' .
                                        'FROM (' .
                                            'SELECT scoreId, userId, leaderboardId, score, @i:=@i+1 AS rank ' .
                                            'FROM score ' .
                                                'JOIN (SELECT @i:=0) exp ' .
                                            'WHERE leaderboardId = ? ' .
                                            'ORDER BY score DESC' .
                                        ') r ' .
                                        'WHERE r.rank > ? AND r.rank <= ?');
    }
    
    public function getWith($userId, $leaderboardId) {
        $this->stmtGet->execute([$leaderboardId, $userId]);
        
        $result = $this->stmtGet->fetch(\PDO::FETCH_ASSOC);
        
        if($result === false) {
            return null;
        }
        
        return new LeaderboardStatsVO($result['userId'], $result['leaderboardId'], $result['score'], $result['scoreId'], $result['rank']);
    }
    
    public function getRange($leaderboardId, $offset, $limit) {
        $end = $offset + $limit;
        $this->stmtGetRange->execute([$leaderboardId, $offset, $end]);
        
        $leaderboardStats = array();
        while(($result = $this->stmtGetRange->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $stat = new LeaderboardStatsVO($result['userId'], $result['leaderboardId'], $result['score'], $result['scoreId'], $result['rank']);
            array_push($leaderboardStats, $stat);
        }

        return $leaderboardStats;
    }
}
