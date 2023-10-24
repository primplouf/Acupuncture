<?php

require_once('./models/Database.class.php');
require_once('./models/PathologyManager.php');
require_once('./models/Pathology.class.php');
require_once('./models/MeridienManager.php');
require_once('./models/Meridien.class.php');
require_once('./models/Twig.class.php');

#[Prefix('/pathology')]
class PathologyController {

    private $_twig;
    private $_db;
    private $_pathologyManager;
    private $_meridienManager;

    public function __construct() {
        $this->_twig = (new Twig())->getTwig();
        $this->_db = (new Database())->connectDb();
        $this->_pathologyManager = new PathologyManager($this->_db);
        $this->_meridienManager = new MeridienManager($this->_db);
    }

    #[Route('/search', 'GET', 'search')]
    public function search() {
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
}

?>