<?php

require_once('Meridien.class.php');

class MeridienManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getMeridiens() {

        $query = $this->_db->prepare('SELECT DISTINCT nom FROM meridien');
        $query->execute();
        
        $meridiens = [];

        foreach($query as $meridien)
        {
            array_push($meridiens, new Meridien(array('name' => $meridien[0])));
        } 

        return $meridiens;
    }

}

?>