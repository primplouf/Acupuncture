<?php

#[Attribute(Attribute::TARGET_CLASS)]
class Prefix {
    private $prefix;

    public function __construct($prefix){
        $this->prefix = $prefix;
    }

    private function setPrefix($prefix){
        $this->prefix = $prefix;
    }

    public function getPrefix(){
        return $this->prefix;
    }
}

?>