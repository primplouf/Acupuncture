<?php

#[Attribute]
class Route {
    private $_endpoint;
    private $_method;
    private $_function;
    private $_controller;

    public function __construct($endpoint, $method, $function, $controller = null){
        $this->_endpoint = $endpoint;
        $this->_method = $method;
        $this->_function = $function;
        $this->_controller = $controller;
    }

    public function getEndpoint(){
      return $this->_endpoint;
    }

    public function getMethod(){
        return $this->_method;
    }

    public function getFunction(){
        return $this->_function;
    }
    
    public function setController($controller){
        $this->_controller = $controller;
    }

    public function setPrefix($prefix){
      $this->_endpoint = $prefix . $this->_endpoint;
    }

    public function call(){
        $function = $this->_function;
        return ($this->_controller)->$function();
    }
}

?>