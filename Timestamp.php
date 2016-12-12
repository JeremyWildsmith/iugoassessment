<?php
use IugoGameLib\TimestampDocumentFactory;

final class Timestamp extends JsonEndpoint {
    
    public function __construct() {
        parent::__construct(true);
    }
    
    protected function generateResults($input) {
        return (new TimestampDocumentFactory())->create();
    }
}