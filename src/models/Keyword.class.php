<?php

class Keyword
{
  private $_idk;
  private $_name;

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

  public function getIdk()
  {
    return $this->_idk;
  }
  
  public function getName()
  {
    return $this->_name;
  }
  
  public function setIdk($idk)
  {
    $this->_idk = $idk;
  }
  
  public function setName($name)
  {
    $this->_name = $name;
  }
}

?>