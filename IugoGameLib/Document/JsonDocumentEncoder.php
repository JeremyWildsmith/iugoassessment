<?php

namespace IugoGameLib\Document;

final class JsonDocumentEncoder implements DocumentEncoder {
    
    private function encodeChildren($node) {
        $children = $node->getChildren();
        
        if(count($children) > 0) {
            if($node->getValue() !== null) {
                throw new DocumentModelLayoutInvalidException("JSON encoder does not allow for nodes to have both child nodes and a value.");
            }
            
            $childMapping = array();
            foreach($children as $c) {
                $childMapping[$c->getName()] = $this->encodeChildren($c);
            }
            
            return $childMapping;
        } else if(is_array($node->getValue()) && 
                    count($node->getValue()) > 0 && 
                    $node->getValue()[0] instanceof DocumentNode) {
            $arr = array();
            foreach ($node->getValue() as $e) {
                array_push($arr, $this->encodeChildren($e));
            }
            
            return $arr;
        }
        else if($node->getValue() === null) {
            return json_decode("{}");
        } else {
            return $node->getValue();
        }
    }
    
    public function encode($model) {
        
        if($model->getValue() !== null) {
            throw new ImproperDocumentFormException("Root json data node must not have a value.");
        }
        
        return json_encode($this->encodeChildren($model));
    }
}
