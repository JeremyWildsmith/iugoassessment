<?php

use IugoGameLib\Document\DocumentNode;
use IugoGameLib\User\DocumentUserInfoDAO;

final class UserLoad extends UserDataEndpoint {
    protected function generateResults($input) {
        $userId = (new DocumentUserInfoDAO($input))->get()->getUserId();
        
        $dao = $this->getUserDataDAO();
        
        $data = $dao->getWith($userId);
        
        if($data === null) {
            return new DocumentNode();
        }
        
        return $data->getData();
    }
}