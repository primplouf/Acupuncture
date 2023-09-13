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
            if (($new_user->login())==($user[1]) || ($new_user->email())==($user[3]))
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
            if (($new_user->login())==($user[1]) && password_verify($new_user->pwd(), $user[2]))
            {
                $new_user->setID($user[0]);
                $new_user->setLogin($user[1]);
                $new_user->setPwd($user[2]);
                $new_user->setEmail($user[3]);
                $checkConnect = True;
            } else if (($new_user->email())==($user[3]) && ($new_user->pwd())==($user[2])) 
            {
                $new_user->setID($user[0]);
                $new_user->setLogin($user[1]);
                $new_user->setPwd($user[2]);
                $new_user->setEmail($user[3]);
                $checkConnect = True;
            }
        } 
        return $checkConnect;
    }

    public function addUser(User $new_user)
    {
        $query = $this->_db->prepare('INSERT INTO user(login, pwd, email) VALUES(:login, :pwd, :email)');
        
        $query->bindValue(':login', $new_user->login());
        $query->bindValue(':pwd', $new_user->pwd());
        $query->bindValue(':email', $new_user->email());

        return $query->execute();
    }
}

?>