<?php
namespace IugoGameLib\Leaderboard;

use IugoGameLib\Document\NoSuchChildNodeException;
use IugoGameLib\Document\ImproperDocumentFormException;
use IugoGameLib\Leaderboard\LeaderboardGetVO;

final class DocumentLeaderboardGetDAO implements LeaderboardGetDAO {
    private $leaderboardGetVo;
    
    public function __construct($documentNode) {
        try {
            $userId = $documentNode->getChild("UserId")->getValue();
            $leaderboardId = $documentNode->getChild("LeaderboardId")->getValue();
            $offset = $documentNode->getChild("Offset")->getValue();
            $limit = $documentNode->getChild("Limit")->getValue();
        
            if(!is_int($userId) || !is_int($leaderboardId) || !is_int($offset) || !is_int($limit))
                throw new ImproperDocumentFormException("Data provided is not valid");
            
            $this->leaderboardGetVo = new LeaderboardGetVO($userId, $leaderboardId, $offset, $limit);
        } catch (NoSuchChildNodeException $e) {
            throw new ImproperDocumentFormException("Document form is invalid.", $e);
        }
    }
    
    public function get() {
        return $this->leaderboardGetVo;
    }
}
