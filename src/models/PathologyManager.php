<?php

require_once('Pathology.class.php');

class PathologyManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getPathologies() {
        
        $query = $this->_db->prepare('SELECT idp, mer, type, patho.desc FROM patho');
        $query->execute();

        $pathologies = [];

        foreach($query as $pathology)
        {
            array_push($pathologies, new Pathology(array('idp' => $pathology[0], 'mer' => $pathology[1], 'type' => $pathology[2], 'desc' => $pathology[3])));
        } 

        return $pathologies;
    }

    public function getSomePathologies($offset, $limit) {

        $query = $this->_db->prepare('SELECT idp, mer, type, patho.desc FROM patho ORDER BY patho.desc OFFSET :offset LIMIT :limit');
        $query->bindValue(':offset', $offset);
        $query->bindValue(':limit', $limit);
        $query->execute();

        $pathologies = [];

        foreach($query as $pathology)
        {
            array_push($pathologies, new Pathology(array('idp' => $pathology[0], 'mer' => $pathology[1], 'type' => $pathology[2], 'desc' => $pathology[3])));
        } 

        return $pathologies;
    }

    public function getPathologyForTypeAndCaracteristic($type, $caracteristic = null) {

        if ($caracteristic == null) {
            $query = ($type == 'm') 
            ? 
                $this->_db->prepare('SELECT patho.desc FROM patho WHERE type LIKE :type AND \'type\' NOT LIKE \'mv%\'') 
            : 
                $this->_db->prepare('SELECT patho.desc FROM patho WHERE type LIKE :type');
            $query->bindValue(':type', $type.'%');
        } else {
            $query = $this->_db->prepare('SELECT patho.desc FROM patho WHERE type LIKE :typepluscaracteristic');
            $query->bindValue(':typepluscaracteristic', '%'.$type.$caracteristic.'%');
        }
        $query->execute();
        
        $pathologies = [];

        foreach($query as $pathology)
        {
            array_push($pathologies, new Pathology(array('desc' => $pathology[0])));
        } 

        return $pathologies;
    }

    public function getPathologyByMeridien($meridien) {

        $query = $this->_db->prepare('SELECT p.desc FROM patho p INNER JOIN meridien m ON p.mer = m.code WHERE m.nom = :meridien');
        $query->bindValue(':meridien', $meridien);
        $query->execute();

        $pathologies = [];

        foreach($query as $pathology)
        {
            array_push($pathologies, new Pathology(array('desc' => $pathology[0])));
        } 

        return $pathologies;
    }

    public function getPathologyByCharacteristic($caracteristic) {

        $query = $this->_db->prepare('SELECT patho.desc FROM patho WHERE patho.desc LIKE :caracteristic');
        $query->bindValue(':caracteristic', '%'.$caracteristic.'%');
        $query->execute();

        $pathologies = [];

        foreach($query as $pathology)
        {
            array_push($pathologies, new Pathology(array('desc' => $pathology[0])));
        } 

        return $pathologies;
    }
}

?>