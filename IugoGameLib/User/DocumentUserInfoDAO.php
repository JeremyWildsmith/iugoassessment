<?php

namespace IugoGameLib\User;

use IugoGameLib\Document\NoSuchChildNodeException;
use IugoGameLib\Document\ImproperDocumentFormException;
use IugoGameLib\User\UserInfoVO;

class DocumentUserInfoDAO implements UserInfoDAO {
    private $userInfo;
    
    public function __construct($documentNode) {
        try {
            $userId = $documentNode->getChild("UserId")->getValue();
            
            if(!is_int($userId))
                throw new ImproperDocumentFormException("Data provided is not valid");
            
            $this->userInfo = new UserInfoVO($userId);
        } catch (NoSuchChildNodeException $e) {
            throw new ImproperDocumentFormException("Document form is invalid.", $e);
        }
    }
    
    public function get() {
        return $this->userInfo;
    }
}
