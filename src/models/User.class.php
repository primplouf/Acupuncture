<?php

class User
{
  protected $_id;
  protected $_login;
  protected $_pwd;
  protected $_email;
  

  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }
  
  
  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }

  public function id()
  {
    return $this->_id;
  }
  
  public function login()
  {
    return $this->_login;
  }
  
  public function pwd()
  {
    return $this->_pwd;
  }
  
  public function email()
  {
    return $this->_email;
  }
  
  public function setId($id)
  {
    $id = (int) $id;
    
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  
  public function setLogin($login)
  {
    if (is_string($login) && !empty($login))
    {
      $this->_login = $login;
    }
  }
  
  public function setPwd($pwd)
  {
    if (is_string($pwd) && !empty($pwd))
    {
      $this->_pwd = $pwd;
    }
  }
  
  public function setEmail($email)
  {
    if (is_string($email) && !empty($email) && strpos($email, "@")!==False)
    {
      $this->_email = $email;
    }
  }
}

?>