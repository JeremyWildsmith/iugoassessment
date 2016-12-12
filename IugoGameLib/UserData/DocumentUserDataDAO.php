<?php

namespace IugoGameLib\UserData;

use IugoGameLib\Document\ImproperDocumentFormException;
use IugoGameLib\Document\NoSuchChildNodeException;

class DocumentUserDataDAO implements ImmutableUserDataDAO {
    private $userData;
    
    public function __construct($documentNode) {
        try {
            $userId = $documentNode->getChild("UserId")->getValue();
            $userData = $documentNode->getChild("Data");
            
            if(!is_int($userId))
                throw new ImproperDocumentFormException("Data provided is not valid");
            
            $this->userData = new UserDataVO($userId, $userData);
        } catch (NoSuchChildNodeException $e) {
            throw new ImproperDocumentFormException("Document form is invalid.", $e);
        }
    }
    
    public function get() {
        return $this->userData;
    }

    public function getWith($userId) {
        if($this->userData->getUserId() === $userId) {
            return $this->userData;
        }
        
        return null;
    }
}

