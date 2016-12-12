<?php

use IugoGameLib\Document\JsonDocumentEncoder;
use IugoGameLib\Document\JsonDocumentDecoder;

abstract class JsonEndpoint extends Endpoint {
    public function __construct($ignoreInput = false) {
        parent::__construct(new JsonDocumentEncoder(), new JsonDocumentDecoder(), 'application/json', $ignoreInput);
    }
}
