<?php

namespace IugoGameLib\UserData;

use IugoGameLib\UserData\UserDataDAO;
use IugoGameLib\UserData\UserDataVO;

class FilesystemUserDataDAO implements UserDataDAO {

    private $pdo;
    private $sourceDirComponents;
    
    private $stmtGet;
    private $stmtInsert;
    
    private $documentDecoder;
    private $documentEncoder;
    
    private $update = array();
    
    public function __construct($pdo, $sourceDir, $documentDecoder, $documentEncoder) {
        $this->pdo = $pdo;
        $this->sourceDirComponents = explode(DIRECTORY_SEPARATOR, trim($sourceDir, DIRECTORY_SEPARATOR));
        $this->documentDecoder = $documentDecoder;
        $this->documentEncoder = $documentEncoder;
        
        $this->stmtGet = $pdo->prepare('SELECT documentId ' .
                                 'FROM userdata '.
                                 'WHERE userId = ?');
        
        $this->stmtInsert = $pdo->prepare('INSERT INTO userdata (userId, documentId) VALUES(?, ?) ');
    }
    
    private function generateDocumentId() {
        return str_pad(abs(crc32(rand())), 10, '0');
    }
    
    private function getPathFromId($userId, $documentId) {
        $dirs = str_split($documentId, 2);
        
        array_push($dirs, $userId);
        
        $path = join(DIRECTORY_SEPARATOR, array_merge($this->sourceDirComponents, $dirs));
        
        return $path;
    }
    
    private function getDocument($userId, $documentId) {
        $sourcePath = $this->getPathFromId($userId, $documentId);
        
        if(!is_file($sourcePath)) {
            throw new FileSystemDocumentAccessException("User data file does not exist on file system.");
        }
        
        $contents = file_get_contents($sourcePath);
        
        if($contents === false) {
            throw new FileSystemDocumentAccessException("Error occured reading from user data from source file.");
        }
        
        return $this->documentDecoder->decode($contents);
    }
    
    private function putFileSystemDocument($userId, $documentId, $document) {
        $path = $this->getPathFromId($userId, $documentId);
        $dir = dirname($path);
        
        if(!file_exists($dir))
            mkdir($dir, 0777, true);
        
        $rawData = $this->documentEncoder->encode($document);
        
        if(file_put_contents($path, $rawData) === false) {
            throw new FileSystemDocumentAccessException("Unable to write user data to respective file.");
        }
    }
    
    public function getWith($userId) {
        $this->stmtGet->execute([$userId]);
        
        $result = $this->stmtGet->fetch(\PDO::FETCH_ASSOC);
        
        if($result === false) {
            return null;
        }
        
        $documentId = $result['documentId'];
        
        $document = $this->getDocument($userId, $documentId);
        
        return new UserDataVO($userId, $document, $documentId);
    }

    public function save() {
        
        foreach($this->update as $u) {
            if($u->getDocumentId() === null) {
                $documentId = $this->generateDocumentId();
                $this->putFileSystemDocument($u->getUserId(), $documentId, $u->getData());
                $this->stmtInsert->execute([$u->getUserId(), $documentId]);
            } else {   
               $this->putFileSystemDocument($u->getUserId(), $u->getDocumentId(), $u->getData());
            }
        }
        
        $this->update = array();
    }

    public function update($userData) {
        array_push($this->update, $userData);
    }
}
