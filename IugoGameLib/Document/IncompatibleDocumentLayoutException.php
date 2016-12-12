<?php

namespace IugoGameLib\Document;

use IugoGameLib\IugoException;

final class IncompatibleDocumentLayoutException extends IugoException {
    public function __construct($reason) {
        parent::__construct($reason);
    }
}