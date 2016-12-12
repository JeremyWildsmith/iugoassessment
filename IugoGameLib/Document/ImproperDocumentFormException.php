<?php

namespace IugoGameLib\Document;

use IugoGameLib\IugoException;

final class ImproperDocumentFormException extends IugoException {
    public function __construct($reason, $cause = null) {
        parent::__construct($reason, $cause);
    }
}