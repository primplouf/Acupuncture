<?php

require_once('./models/Database.class.php');
require_once('./models/PathologyManager.php');
require_once('./models/Pathology.class.php');
require_once('./models/MeridienManager.php');
require_once('./models/Meridien.class.php');
require_once('./models/SymptomeManager.php');
require_once('./models/Symptome.class.php');
require_once('./models/KeywordManager.php');
require_once('./models/Keyword.class.php');
require_once('./models/Twig.class.php');

#[Prefix('/pathology')]
class PathologyController {

    private $_twig;
    private $_db;
    private $_pathologyManager;
    private $_meridienManager;
    private $_symptomeManager;
    private $_keywordManager;

    public function __construct() {
        $this->_twig = (new Twig())->getTwig();
        $this->_db = (new Database())->connectDb();
        $this->_pathologyManager = new PathologyManager($this->_db);
        $this->_meridienManager = new MeridienManager($this->_db);
        $this->_symptomeManager = new SymptomeManager($this->_db);
        $this->_keywordManager = new KeywordManager($this->_db);
    }

    #[Route('/search', ['GET','POST'], 'search')]
    public function search() {

        $pathoPerPage = 10;
        $pathologies = $this->_pathologyManager->getPathologies();
        $somePathologies = [];
        $counterPatho = count($pathologies);
        $params = array();

        if ($counterPatho != 0) {
        
            if (isset($_GET['pagination']) && !empty($_GET['pagination']) && $_GET['pagination'] > 0) {

                $_GET['pagination'] = intval($_GET['pagination']);
                $currentPage = $_GET['pagination'];
            } else {

                $currentPage = 1;
            }
        
            $start = ($currentPage - 1) * $pathoPerPage;
            $totalPages = ceil($counterPatho / $pathoPerPage);
            $params['totalPages'] = $totalPages;
            $somePathologies = $this->_pathologyManager->getSomePathologies($start, $pathoPerPage);
        }
        
        if (isset($_POST['pathology']) and !empty($_POST['pathology'])) {
            $pathology = htmlspecialchars($_POST['pathology']);
            $symptoms = $this->_symptomeManager->getSymptomesByPatho($pathology);
            $params['pathology'] = $pathology;
        } else {
            $symptoms = [];
        }

        
        $params['somePathologies'] = $somePathologies;
        $params['symptoms'] = $symptoms;

        echo $this->_twig->render('recherchePathologie.twig', $params);
    }

    #[Route('/filter', ['GET','POST'], 'filter')]
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

    #[Route('/keywords', ['GET','POST'], 'keywordSearch')]
    public function keywordSearch() {
        $params = array();
        session_start();
        if (!isset($_SESSION['email'])) {

            header('Location: /user/login');
            exit();
        }
        
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $search = $_POST['search'];
            $search = htmlspecialchars($search);
            $totalRows = 0;
            $totalPage = 0;
            $pathoPerPage = 10;
            $totalRows = $this->_keywordManager->countKeywords($search);
        
            if ($totalRows > 0) {
        
                if (isset($_GET['pagination']) and !empty($_GET['pagination']) and $_GET['pagination'] > 0) {

                    $_GET['pagination'] = intval($_GET['pagination']);
                    $currentPage = $_GET['pagination'];
                } else {

                    $currentPage = 1;
                }
        
                $start = ($currentPage - 1) * $pathoPerPage;
                $totalPage = ceil($totalRows / $pathoPerPage);
                $params['totalPage'] = $totalPage;
                $lines = $this->_keywordManager->selectSomePathologyByKeyword($search, $start, $pathoPerPage);
                $params['lines'] = $lines;
            }

            $params['search'] = $search;
        }

        echo $this->_twig->render('keywords.twig', $params);
    }

}

?>