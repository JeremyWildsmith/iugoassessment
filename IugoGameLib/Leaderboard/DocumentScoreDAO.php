<?php
namespace IugoGameLib\Leaderboard;

use IugoGameLib\Document\NoSuchChildNodeException;
use IugoGameLib\Document\ImproperDocumentFormException;
use IugoGameLib\Leaderboard\ImmutableScoreDAO;
use IugoGameLib\Leaderboard\ScoreVO;

final class DocumentScoreDAO implements ImmutableScoreDAO {
    private $scoreVo;
    
    public function __construct($documentNode) {
        try {
            $userId = $documentNode->getChild("UserId")->getValue();
            $leaderboardId = $documentNode->getChild("LeaderboardId")->getValue();
            $score = $documentNode->getChild("Score")->getValue();
        
            if(!is_int($userId) || !is_int($leaderboardId) || !is_int($score))
                throw new ImproperDocumentFormException("Data provided is not valid");
            
            $this->scoreVo = new ScoreVO($userId, $leaderboardId, $score);
        } catch (NoSuchChildNodeException $e) {
            throw new ImproperDocumentFormException("Document form is invalid.", $e);
        }
    }
    
    public function getWith($userId, $leaderboardId) {
        if($this->scoreVo->getUserId() != $userId || $this->scoreVo->getLeaderboardId() != $leaderboardId) {
            return [];
        }
        
        return [$this->scoreVo];
    }
    
    public function getAll() {
        return [$this->scoreVo];
    }
    
    public function get() {
        return $this->scoreVo;
    }
}
