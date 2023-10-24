<?php

require_once('Pathology.class.php');

class PathologyManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

}

?>