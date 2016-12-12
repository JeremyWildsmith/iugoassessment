<?php

use IugoGameLib\UserData\FilesystemUserDataDAO;
use IugoGameLib\Document\JsonDocumentDecoder;
use IugoGameLib\Document\JsonDocumentEncoder;

abstract class UserDataEndpoint extends JsonEndpoint {
    const USER_DATA_DIR = "userData";
    
    private $userDataDao;
    
    public function __construct() {
        parent::__construct();
        
        $pdo = (new PdoFactory())->create(); 
        $this->userDataDao = new FilesystemUserDataDAO($pdo, UserDataEndpoint::USER_DATA_DIR, new JsonDocumentDecoder(), new JsonDocumentEncoder());
    }
    
    public function getUserDataDAO() {
        return $this->userDataDao;
    }
}
