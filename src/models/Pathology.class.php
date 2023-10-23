<?php

class Pathology
{
  private $_idp;
  private $_mer;
  private $_type;
  private $_desc;

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

  public function getIdp()
  {
    return $this->_idp;
  }
  
  public function getMer()
  {
    return $this->_mer;
  }
  
  public function getType()
  {
    return $this->_type;
  }
  
  public function getDesc()
  {
    return $this->_desc;
  }
  
  public function setIdp($idp)
  {
    $this->_idp = $idp;
  }
  
  public function setMer($mer)
  {
    $this->_mer = $mer;
  }

  public function setType($type)
  {
    $this->_type = $type;
  }

  public function setDesc($desc)
  {
    $this->_desc = $desc;
  }
}

?>