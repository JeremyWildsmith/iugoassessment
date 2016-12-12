<?php

namespace IugoGameLib\Document;

use IugoGameLib\IugoException;

final class NoSuchChildNodeException extends IugoException {
    public function __construct($reason) {
        parent::__construct($reason);
    }
}