<?php

class Twig {

    private $_loader;

    public function __construct(){
        $this->_loader = new Twig\Loader\FilesystemLoader('views');
    }

    public function getTwig(){
        return new Twig\Environment($this->_loader);
    }

}

?>