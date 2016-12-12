<?php

namespace IugoGameLib\Document;

final class DocumentNode {

    private $name;
    private $value;
    private $children = array();

    public function __construct($name = "", $value = null) {
        $this->name = $name;
        $this->value = $value;
    }

    //Child is document model.
    public function addChild($child) {
        if (in_array($child, $this->children)) {
            return;
        }

        array_push($this->children, $child);
        
        return $child;
    }

    //Child is document model.
    public function removeChild($child) {
        $key = array_search($child, $this->children);

        if ($key === false) {
            return;
        }

        unset($this->children[$key]);
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    //return is DocumentModel
    public function getChild($name) {
        foreach ($this->children as $c) {
            if ($c->name === $name) {
                return $c;
            }
        }

        throw new NoSuchChildNodeException("Child node $name does not exist.");
    }

    public function hasChild($name) {
        foreach ($this->children as $c) {
            if ($c->name === $name) {
                return true;
            }
        }

        return false;
    }

    public function getChildren() {
        return $this->children;
    }

}
