<?php

require_once('Keyword.class.php');

class KeywordManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function countKeywords($keyword) {

        $query = $this->_db->prepare('SELECT COUNT(DISTINCT p.idp) from keywords k INNER JOIN keysympt ks ON ks.idk = k.idk INNER JOIN symptpatho sp ON sp.ids = ks.ids INNER JOIN patho p ON p.idp = sp.idp WHERE k.name LIKE :name');
        $query->bindValue(':name', $keyword);
        $query->execute();

        return $query->fetch()[0];
    }

    public function selectSomePathologyByKeyword($keyword, $offset, $limit) {

        $query = $this->_db->prepare('SELECT DISTINCT p.desc from keywords k INNER JOIN keysympt ks ON ks.idk = k.idk INNER JOIN symptpatho sp ON sp.ids = ks.ids INNER JOIN patho p ON p.idp = sp.idp WHERE k.name LIKE :name ORDER BY p.desc OFFSET :offset LIMIT :limit');
        $query->bindValue(':name', $keyword);
        $query->bindValue(':offset', $offset);
        $query->bindValue(':limit', $limit);
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