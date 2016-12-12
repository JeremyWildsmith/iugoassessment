<?php

namespace IugoGameLib\Document;

use IugoGameLib\Document\DocumentNode;

class JsonDocumentDecoder implements DocumentDecoder {

    public function decodeChildren($node, $value) {
        
        if($value == null || is_scalar($value)) {
          $node->setValue($value);  
        } else if(is_array($value)) {
            $arrBuffer = array();
            foreach($value as $entry) {
                if(is_scalar($entry)) {
                    array_push($arrBuffer, $entry);
                } else {
                    $n = new DocumentNode();
                    $this->decodeChildren($n, $entry);
                    array_push($arrBuffer, $n);
                }
            }
            
            $node->setValue($arrBuffer);
        } else {
            foreach (get_object_vars($value) as $key => $value) {
                $valBuffer = new DocumentNode($key);
                if(is_scalar($value)) {
                    $valBuffer->setValue($value);
                } else {
                    $this->decodeChildren($valBuffer, $value);
                }
                
                $node->addChild($valBuffer);
            }
        }
    }

    public function decode($source) {
        $node = new DocumentNode();
        $arr = json_decode($source);

        if($arr === null || is_array($arr) || is_scalar($arr)) {
            throw new ImproperDocumentFormException("Invalid JSON document or JSON recursion is too deep to be processed.");
        }
        
        $this->decodeChildren($node, $arr);

        return $node;
    }

}
