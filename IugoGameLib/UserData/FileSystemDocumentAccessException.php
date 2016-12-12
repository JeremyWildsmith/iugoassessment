<?php

namespace IugoGameLib\UserData;

use IugoGameLib\IugoException;

class FileSystemDocumentAccessException extends IugoException {
    public function __construct($reason) {
        parent::__construct($reason);
    }
}
