<?php

class Twig {

    private $_twig;

    public function __construct(){
        $loader = new Twig\Loader\FilesystemLoader('views');
        $this->_twig = new Twig\Environment($loader);
    }

    public function render($template, $params = NULL) {
        
        $params["isConnected"] = isset($_SESSION["email"]);
        return $this->_twig->render($template, $params);
    }

}

?>