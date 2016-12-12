<?php

namespace IugoGameLib;

class IugoException extends \Exception {
    public function __construct($reason, $cause = null) {
        parent::__construct($reason, 0, $cause);
    }
}