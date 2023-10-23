<?php

#[Attribute(Attribute::TARGET_CLASS)]
class Prefix {
    private $_prefix;

    public function __construct($prefix){
        $this->_prefix = $prefix;
    }

    private function setPrefix($prefix){
        $this->_prefix = $prefix;
    }

    public function getPrefix(){
        return $this->_prefix;
    }
}

?>