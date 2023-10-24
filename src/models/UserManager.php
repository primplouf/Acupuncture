<?php

require_once("User.class.php");

class UserManager {

    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function noRegister(User $new_user)
    {
        $noRegister = True;
        $query = $this->_db->prepare("SELECT * FROM user");
        $query->execute();
        foreach($query as $user)
        {
            if ($new_user->getEmail()==$user[3])
            {
                $noRegister = False;
            }
        }
        return $noRegister;
    }

    public function checkConnection(User $new_user)
    {
        $checkConnect = False;
        $query = $this->_db->prepare("SELECT * FROM user");
        $query->execute();
        foreach($query as $user)
        {
            if (($new_user->getEmail()==$user[3]) && ($new_user->getPwd())==($user[2])) 
            {
                $new_user->setID($user[0]);
                $new_user->setPwd($user[2]);
                $new_user->setEmail($user[3]);
                $checkConnect = True;
            }
        } 
        return $checkConnect;
    }

    public function addUser(User $new_user)
    {
        $query = $this->_db->prepare('INSERT INTO user(firstname, lastname, pwd, email) VALUES(:firstname, :lastname, :pwd, :email)');
        
        $query->bindValue(':firstname', $new_user->getFirstname());
        $query->bindValue(':lastname', $new_user->getLastname());
        $query->bindValue(':pwd', $new_user->getPwd());
        $query->bindValue(':email', $new_user->getEmail());

        return $query->execute();
    }
}

?>