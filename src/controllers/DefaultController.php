<?php

require_once('./models/Twig.class.php');

#[Prefix('/')]
class DefaultController {

    private $_twig;

    public function __construct()
    {
        $this->_twig = (new Twig())->getTwig();
    }

    #[Route('',['GET'],'default')]
    public function default(){
        echo $this->_twig->render('accueil.twig');
    }
}
?>