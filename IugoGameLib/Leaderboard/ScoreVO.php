<?php
namespace IugoGameLib\Leaderboard;

class ScoreVO {
    private $scoreId;
    private $userId;
    private $leaderboardId;
    private $score;
    
    public function __construct($userId, $leaderboardId, $score, $scoreId = null) {
        $this->userId = $userId;
        $this->leaderboardId = $leaderboardId;
        $this->score = $score;
        $this->scoreId = $scoreId;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getLeaderboardId() {
        return $this->leaderboardId;
    }

    public function getId() {
        return $this->scoreId;
    }
    
    public function getScore() {
        return $this->score;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setLeaderboardId($leaderboardId) {
        $this->leaderboardId = $leaderboardId;
    }

    public function setScore($score) {
        $this->score = $score;
    }
}