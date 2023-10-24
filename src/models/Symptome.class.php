<?php

class Symptome
{
  private $_ids;
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

  public function getIds()
  {
    return $this->_ids;
  }
  
  public function getDesc()
  {
    return $this->_desc;
  }
  
  public function setIds($ids)
  {
    $this->_ids = $ids;
  }
  
  public function setDesc($desc)
  {
    $this->_desc = $desc;
  }
}

?>