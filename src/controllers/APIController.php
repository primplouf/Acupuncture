<?php

require_once('./models/Database.class.php');
require_once('./models/SymptomeManager.php');
require_once('./models/Symptome.class.php');

#[Prefix('/api')]
class APIController {

    private $_db;
    private $_symptomeManager;

    public function __construct() {
        $this->_db = (new Database())->connectDb();
        $this->_symptomeManager = new SymptomeManager($this->_db);
    }

    private function setHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    #[Route('/symptoms', ['GET'], 'getSymptoms')]
    public function getSymptoms() {

        $this->setHeaders();

        if (isset($_GET['pathology']) && !empty($_GET['pathology'])) {
            $pathology = htmlspecialchars($_GET['pathology']);
            $symptoms = $this->_symptomeManager->getSymptomesByPatho($pathology);
        } else {
            $symptoms = $this->_symptomeManager->getSymptoms();
        }

        http_response_code(200);

        echo json_encode($symptoms);
    }
}

?>