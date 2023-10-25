<?php

require_once("Prefix.class.php");
require_once("Route.class.php");

class Router {

    private $routes;

    public function __construct(){
        $this->routes = [];
    }

    private function appendRoute($route){
        if (!array_key_exists($route->getEndpoint(), $this->routes)) {
            $this->routes[$route->getEndpoint()] = $route;
        }
    }

    private function get_classname($file){

        $fp = fopen($file, 'r');
        $class = $buffer = '';
        $i = 0;

        while (!$class) {

            if (feof($fp)) break;
    
            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);
    
            if (strpos($buffer, '{') === false) continue;
    
            for (;$i<count($tokens);$i++) {

                if ($tokens[$i][0] === T_CLASS) {
                    for ($j=$i+1;$j<count($tokens);$j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i+2][1];
                        }
                    }
                }

            }

        }

        return $class;

    }

    public function loadRoutes($controllerDirectory){
        
        if (!is_dir($controllerDirectory)){
            return;
        }

        $controllers = array_diff(scandir($controllerDirectory), array('..', '.'));
        
        foreach($controllers as $controller){
            
            $path = $controllerDirectory.$controller;
            $classname = $this->get_classname($path);
            require_once($path);
            $controllerObject = new $classname();
            $reflexionClass = new ReflectionClass($classname);
            $prefixReflectionAttributes = $reflexionClass->getAttributes(Prefix::class);
            $prefix = "";

            if (count($prefixReflectionAttributes) != 0) {
                $prefix = $prefixReflectionAttributes[0]->newInstance();
            }

            foreach($reflexionClass->getMethods() as $method){
                
                $methodRouteAttributes = $method->getAttributes(Route::class);
                
                if (count($methodRouteAttributes) != 0) {
                    $route = $methodRouteAttributes[0]->newInstance();
                    $route->setController($controllerObject);
                    $route->setPrefix($prefix->getPrefix());
                    $this->appendRoute($route);
                }

            }
        }
    }

    public function matchRoute($endpoint){
        session_start();
        if(!isset($_SESSION['email'])) {
            session_unset();
        }
        $route = (array_key_exists($endpoint, $this->routes)) ? $this->routes[$endpoint] : $this->routes["/"];
        return $route->call();
    }
}

?>