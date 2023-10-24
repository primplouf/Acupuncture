<?php

class database {
    
    protected $_dbName;
    protected $_dbPort;
    protected $_dbHost;
    protected $_dbPwd;
    protected $_dbLogin;

    public function __construct(){
        $this->_dbHost = 'postgres';
        $this->_dbPort = '5432';
        $this->_dbName = 'mydatabase';
        $this->_dbLogin = 'myuser';
        $this->_dbPwd = 'mypassword';
    }

    public function connectDb(){
        try {
            $bdd = new PDO('pgsql:host='.$this->_dbHost.';port='.$this->_dbPort.';dbname='.$this->_dbName.';charset=utf8', $this->_dbLogin, $this->_dbPwd);
            return $bdd;
        }catch (Exception $e) {
            exit('Erreur '.$e->getCode().' : '.$e->getMessage());
        }
    }
}

?>