<?php

class Meridien
{
  private $_code;
  private $_name;
  private $_element;
  private $_yin;

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

  public function getCode()
  {
    return $this->_code;
  }
  
  public function getName()
  {
    return $this->_name;
  }
  
  public function getElement()
  {
    return $this->_element;
  }
  
  public function getYin()
  {
    return $this->_yin;
  }
  
  public function setCode($code)
  {
    $this->_code = $code;
  }
  
  public function setName($name)
  {
    $this->_name = $name;
  }

  public function setElement($element)
  {
    $this->_element = $element;
  }

  public function setYin($yin)
  {
    $this->_yin = $yin;
  }
}

?>