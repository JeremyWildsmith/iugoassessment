<?php

namespace IugoGameLib\User;

class UserInfoVO {
    private $userId;
    
    public function __construct($userId) {
        $this->userId = $userId;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
}
