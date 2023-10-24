<?php

#[Prefix('/pathology')]
class FiltrePathologieController {
    private $_twig;

    public function __construct() {
        // le dossier ou on trouve les templates
        $loader = new Twig\Loader\FilesystemLoader('views');
        // initialiser l'environement Twig
        $this->_twig = new Twig\Environment($loader);
    }

    #[Route('','GET','default')]
    public function default(){
        echo 'default';
    }
    #[Route('/filter','GET','pathology')]
    public function pathology(){
        if(isset($this->_twig)) {
            echo $this->_twig->render('filtrePathologie.twig');
        }
    }
}
?>