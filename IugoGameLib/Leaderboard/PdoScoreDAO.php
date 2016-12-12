<?php
namespace IugoGameLib\Leaderboard;

use IugoGameLib\Leaderboard\ScoreDAO;
use IugoGameLib\Leaderboard\ScoreVO;

final class PdoScoreDAO implements ScoreDAO {
    private $pdo;
    
    private $update = array();
    private $delete = array();
    
    private $stmtGetAll;
    private $stmtGetWith;
    private $stmtDelete;
    private $stmtInsert;
    private $stmtUpdate;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->stmtGetAll = $pdo->prepare('SELECT scoreId, userId, leaderboardId, score ' .
                                                'FROM score');
        
        $this->stmtGetWith = $pdo->prepare('SELECT scoreId, userId, leaderboardId, score ' .
                                                'FROM score ' .
                                                'WHERE userId=? AND leaderboardId=?');
        
        $this->stmtDelete = $pdo->prepare('DELETE FROM score ' .
                                                'WHERE scoreId=?');
        
        $this->stmtInsert = $pdo->prepare('INSERT INTO score (userId, leaderboardId, score) ' .
                                                'VALUES(?, ?, ?)');
        
        $this->stmtUpdate = $pdo->prepare('UPDATE score SET userId=?, leaderboardId=?, score=? ' .
                                                'WHERE scoreId=?');
    }

    public function delete($score) {
        array_push($this->delete, $score);
    }
    
    public function getAll() {
        $scoreVos = array();
        
        $this->stmtGetAll->execute();
        while(($res = $this->stmtGetAll->fetch(\PDO::FETCH_ASSOC)) !== false) {
            array_push($scoreVos, new ScoreVO($res['userId'], $res['leaderboardId'], $res['score'], $res['scoreId']));
        }
        
        return $scoreVos;
    }

    public function getWith($userId, $leaderboardId) {
        $scoreVos = array();
        
        $this->stmtGetWith->execute([$userId, $leaderboardId]);
        while(($res = $this->stmtGetWith->fetch(\PDO::FETCH_ASSOC)) !== false) {
            array_push($scoreVos, new ScoreVO($res['userId'], $res['leaderboardId'], $res['score'], $res['scoreId']));
        }
        
        return $scoreVos;
    }

    public function save() {
        
        foreach($this->update as $u) {
            if($u->getId() === null) {
                $this->stmtInsert->execute([$u->getUserId(), $u->getLeaderboardId(), $u->getScore()]);
            } else {
                $this->stmtUpdate->execute([$u->getUserId(), $u->getLeaderboardId(), $u->getScore(), $u->getId()]);    
            }
        }
 
        foreach($this->delete as $d) {
            if($u->getId() !== null) {
                $this->stmtDelete->execute([$d->getId()]);
            }
        }
        
        $this->update = array();
        $this->delete = array();
    }

    public function update($score) {
        array_push($this->update, $score);
    }
}
