<?php

require_once('./models/Database.class.php');
require_once('./models/PathologyManager.php');
require_once('./models/Pathology.class.php');
require_once('./models/MeridienManager.php');
require_once('./models/Meridien.class.php');
require_once('./models/SymptomeManager.php');
require_once('./models/Symptome.class.php');
require_once('./models/Twig.class.php');

#[Prefix('/pathology')]
class PathologyController {

    private $_twig;
    private $_db;
    private $_pathologyManager;
    private $_meridienManager;
    private $_symptomeManager;

    public function __construct() {
        $this->_twig = (new Twig())->getTwig();
        $this->_db = (new Database())->connectDb();
        $this->_pathologyManager = new PathologyManager($this->_db);
        $this->_meridienManager = new MeridienManager($this->_db);
        $this->_symptomeManager = new SymptomeManager($this->_db);
    }

    #[Route('/search', 'POST', 'search')]
    public function search() {

        $pathoPerPage = 10;
        $pathologies = $this->_pathologyManager->getPathologies();
        $somePathologies = [];
        $counterPatho = count($pathologies);

        if ($counterPatho != 0) {
        
            if (isset($_GET['pagination']) && !empty($_GET['pagination']) && $_GET['pagination'] > 0) {

                $_GET['pagination'] = intval($_GET['pagination']);
                $currentPage = $_GET['pagination'];
            } else {

                $currentPage = 1;
            }
        
            $start = ($currentPage - 1) * $pathoPerPage;
            $totalPages = ceil($counterPatho / $pathoPerPage);
            $somePathologies = $this->_pathologyManager->getSomePathologies($start, $pathoPerPage);
        }
        
        if (isset($_POST['pathology']) and !empty($_POST['pathology'])) {
            $pathology = htmlspecialchars($_POST['pathology']);
            $symptoms = $this->_symptomeManager->getSymptomesByPatho($pathology);
        } else {
            $symptoms = [];
        }

        echo $this->_twig->render('recherchePathologie.twig');
    }

    #[Route('/filter', 'GET', 'filter')]
    public function filter() {
        
        $meridiens = $this->_meridienManager->getMeridiens();        
        $pathologies = [];

        if (isset($_POST['input']) && !empty($_POST['input'])) {

            $input = htmlspecialchars($_POST['input']);

            switch($input){
                case 'showtype':

                    if ((isset($_POST['type']) && !empty($_POST['type'])) && (isset($_POST['caracteristic']) && !empty($_POST['caracteristic']))) {

                        $type = htmlspecialchars($_POST['type']);
                        $caracteristic = htmlspecialchars($_POST['caracteristic']);

                        $pathologies = ($caracteristic == "choose") 
                            ?
                                $this->_pathologyManager->getPathologyForTypeAndCaracteristic($type)
                            :
                                $this->_pathologyManager->getPathologyForTypeAndCaracteristic($type, $caracteristic);
                    }
                    break;
                case 'showmeridien':
                    
                    if (isset($_POST['meridien']) && !empty($_POST['meridien'])) {

                        $meridien = htmlspecialchars($_POST['meridien']);
                        $pathologies = $this->_pathologyManager->getPathologyByMeridien($meridien);
                    }
                    break;
                case 'showcaracteristic':

                    if (isset($_POST['caracteristic']) && !empty($_POST['caracteristic'])) {

                        $caracteristic = htmlspecialchars($_POST['caracteristic']);
                        $pathologies = $this->_pathologyManager->getPathologyByCharacteristic($caracteristic);
                    }
                    break;
            }
        }
        
        $params = array();

        $params['meridiens'] = $meridiens;
        $params['pathologies'] = $pathologies;

        echo $this->_twig->render('filtrePathologie.twig', $params);
    }

    #[Route('/keywords', 'POST', 'keywordSearch')]
    public function keywordSearch() {

        if (!isset($_SESSION['email'])) {

            header('Location: /user/login');
            exit();
        }
        /*
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $search = $_POST['search'];
            $elem_total = 0;
            $page_total = 0;
            $q = htmlspecialchars($q);
            $elem_page = 10;
            $elem_total = $keywords->countRows($q);
        
            // Gestion de la pagination
            if ($elem_total > 0) {
        
                if (isset($_GET['pagination']) and !empty($_GET['pagination']) and $_GET['pagination'] > 0) {
                    $_GET['pagination'] = intval($_GET['pagination']);
                    $pageCourante = $_GET['pagination'];
                } else {
                    $pageCourante = 1;
                }
        
                $depart = ($pageCourante - 1) * $elem_page;
                $page_total = ceil($elem_total / $elem_page);
        
                $lignes = $keywords->selectPathoWithName($q, $depart, $elem_page);
            }
        }
*/
        echo $this->_twig->render('keywords.twig');
    }
}

?>