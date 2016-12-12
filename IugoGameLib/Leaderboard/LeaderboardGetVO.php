<?php

namespace IugoGameLib\Leaderboard;

class LeaderboardGetVO {
   private $userId;
   private $leaderboardId;
   private $offset;
   private $limit;
   
   public function __construct($userId, $leaderboardId, $offset, $limit) {
       $this->userId = $userId;
       $this->leaderboardId = $leaderboardId;
       $this->offset = $offset;
       $this->limit = $limit;
   }
   
   public function getUserId() {
       return $this->userId;
   }

   public function getLeaderboardId() {
       return $this->leaderboardId;
   }

   public function getOffset() {
       return $this->offset;
   }

   public function getLimit() {
       return $this->limit;
   }

   public function setUserId($userId) {
       $this->userId = $userId;
   }

   public function setLeaderboardId($leaderboardId) {
       $this->leaderboardId = $leaderboardId;
   }

   public function setOffset($offset) {
       $this->offset = $offset;
   }

   public function setLimit($limit) {
       $this->limit = $limit;
   }


}
