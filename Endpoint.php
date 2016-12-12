<?php
require_once(__DIR__ . "/AutoLoader.php");

use IugoGameLib\Document\DocumentNode;
use IugoGameLib\ErrorDocumentFactory;
use IugoGameLib\IugoException;

abstract class Endpoint {
    private $encoder;
    private $decoder;
    private $contentTypeHeader;
    private $ignoreInput;
    
    public function __construct($encoder, $decoder, $contentTypeHeader, $ignoreInput = false) {
        $this->encoder = $encoder;
        $this->decoder = $decoder;
        $this->contentTypeHeader = $contentTypeHeader;
        $this->ignoreInput = $ignoreInput;
    }
    
    private final function echoDocument($document) {
        header('Content-Type: ' . $this->contentTypeHeader);
        echo $this->encoder->encode($document);
    }
    
    protected final function error($message) {
        $this->echoDocument((new ErrorDocumentFactory())->create($message));
        die();
    }
    
    public final function execute() {
        try {
            $docInput = new DocumentNode();
            
            if(!$this->ignoreInput) {
                $rawInput = file_get_contents("php://input");

                if($rawInput === false) {
                    $this->error("Unable to read input data.");
                }

                $docInput = $this->decoder->decode($rawInput);
            }
            
            $result = $this->generateResults($docInput);
            $this->echoDocument($result);
        } catch (IugoException $ex) {
            $this->error($ex->getMessage());
        }
    }
    
    protected abstract function generateResults($input);
    
}
