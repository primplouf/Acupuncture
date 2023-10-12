<?php

#[Attribute]
class Route {
    private $endpoint;
    private $method;
    private $function;

    public function __construct($data){
        $array = array(
          "endpoint"=>$data
        );
        $this->hydrate($array);
    }
    
    
    public function hydrate(array $donnees)
    {
      foreach ($donnees as $key => $value)
      {
        $meth = 'set'.ucfirst($key);
        
        if (method_exists($this, $meth))
        {
          $this->$meth($value);
        }
      }
    }

    private function setEndpoint($endpoint){
        $this->endpoint = $endpoint;
    }

    private function setMethod($method){
        $this->method = $method;
    }

    private function setFunction($function){
        $this->function = $function;
    }
}

?>