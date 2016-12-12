<?php

namespace IugoGameLib\UserData;

final class UserDataVO {
    private $userId;
    private $documentId;
    private $data;
    
    public function __construct($userId, $data, $documentId = null) {
        $this->userId = $userId;
        $this->data = $data;
        $this->documentId = $documentId;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getDocumentId() {
        return $this->documentId;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
}
