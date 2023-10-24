<?php

require_once('./models/Database.class.php');
require_once('./models/PathologyManager.php');
require_once('./models/Pathology.class.php');

#[Prefix('/pathology')]
class PathologyController {

    private $_twig;
    private $_db;
    private $_pathologyManager;

    public function __construct() {
        // le dossier ou on trouve les templates
        $loader = new Twig\Loader\FilesystemLoader('views');
        // initialiser l'environement Twig
        $this->_twig = new Twig\Environment($loader);
        $this->_db = (new Database())->connectDb();
        $this->_pathologyManager = new PathologyManager($this->_db);
    }

    #[Route('/filter', 'GET', 'filter')]
    public function filter() {

        $reponsemeri = $filtrePathologie->getMeri();
        $rows = array();
        if (isset($_POST['input']) and !empty($_POST['input'])) {
            $input = htmlspecialchars($_POST['input']);

            // Si l'utilisateur choisit "Type"
            if ($input == "affichertype") {
                // Si les 2 champs type et caractéristique ne sont pas remplis
                if ((isset($_POST['type']) and !empty($_POST['type'])) and (isset($_POST['caract']) and !empty($_POST['caract']))) {
                    $type = htmlspecialchars($_POST['type']);
                    $caract = htmlspecialchars($_POST['caract']);
                    if ($caract == "choisir") {
                        // Si l'utilisateur choisit "Méridien"
                        if ($type == 'm') {
                            $rows = $filtrePathologie->getPathoForMeridienType();
                        } else {
                            $rows = $filtrePathologie->getPathoForSelectType($type);
                        }
                    } else {
                        $rows = $filtrePathologie->getPathoForSelectTypeAndCaract($type, $caract);
                    }
                }
            } else if ($input == "affichermeridien") { // Si l'utilisateur choisit "Méridien"

                if (isset($_POST['meridien']) and !empty($_POST['meridien'])) {
                    // On appelle la fonction getMeridien pour récuperer les méridiens
                    $meridien = htmlspecialchars($_POST['meridien']);
                    $rows = $filtrePathologie->getMeridien($meridien);
                }
            } else { // Si l'utilisateur choisit "Caract"
                if (isset($_POST['caract']) and !empty($_POST['caract'])) {
                    // On appelle la fonction getPathoForCaract pour récuperer les caractéristiques des pathologies
                    $caract = htmlspecialchars($_POST['caract']);
                    $rows = $filtrePathologie->getPathoForCaract($caract);
                }
            }
        }
        $extraJs = "script_patho.js";
        echo $this->_twig->render('filtrePathologie.twig');
    }
}

?>