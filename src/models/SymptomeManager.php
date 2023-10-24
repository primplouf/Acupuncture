<?php

require_once('Symptome.class.php');

class SymptomeManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getSymptomesByPatho($pathology) {

        $query = $this->_db->prepare('SELECT s.desc FROM symptome s INNER JOIN symptPatho sp ON sp.idS=s.idS  INNER JOIN patho p ON p.idP=sp.idP WHERE p.desc = :pathology');
        $query->bindValue(':pathology', $pathology);
        $query->execute();
        
        $symptoms = [];

        foreach($query as $symptom)
        {
            array_push($symptoms, new Symptome(array('desc' => $symptom[0])));
        } 

        return $symptoms;
    }

}

?>