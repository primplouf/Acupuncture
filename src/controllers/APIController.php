<?php

require_once('./models/Database.class.php');
require_once('./models/PathologyManager.php');
require_once('./models/Pathology.class.php');

#[Prefix('/api')]
class APIController {

    private $_db;
    private $_pathologyManager;

    public function __construct() {
        $this->_db = (new Database())->connectDb();
        $this->_pathologyManager = new PathologyManager($this->_db);
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

    }
}

?>