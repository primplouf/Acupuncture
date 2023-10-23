<?php

#[Attribute]
class Route {
    private $endpoint;
    private $method;
    private $function;
    private $controller;

    public function __construct($endpoint, $method, $function, $controller = null){
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->function = $function;
        $this->controller = $controller;
    }

    public function getEndpoint(){
      return $this->endpoint;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getFunction(){
        return $this->function;
    }
    
    public function setController($controller){
        $this->controller = $controller;
    }

    public function setPrefix($prefix){
      $this->endpoint = $prefix . $this->endpoint;
    }

    public function call(){
        $function = $this->function;
        return ($this->controller)->$function();
    }
}

?>