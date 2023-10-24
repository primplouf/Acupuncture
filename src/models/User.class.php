<?php

class User
{
  private $_id;
  private $_pwd;
  private $_firstanme;
  private $_lastname;
  private $_email;
  

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

  public function getId()
  {
    return $this->_id;
  }
  
  public function getPwd()
  {
    return $this->_pwd;
  }
  
  public function getEmail()
  {
    return $this->_email;
  }

  public function getFirstname()
  {
    return $this->_firstanme;
  }

  public function getLastname()
  {
    return $this->_lastname;
  }
  
  public function setId($id)
  {
    $id = (int) $id;
    
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  
  public function setPwd($pwd)
  {
    if (is_string($pwd) && !empty($pwd))
    {
      $this->_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }
  }
  
  public function setEmail($email)
  {
    if (is_string($email) && !empty($email) && strpos($email, "@")!==False)
    {
      $this->_email = $email;
    }
  }

  public function setFirstname($firstanme)
  {
    $this->_firstanme = $firstanme;
  }

  public function setLastname($lastname)
  {
    $this->_lastname = $lastname;
  }
}

?>