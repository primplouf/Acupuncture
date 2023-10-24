<?php

require_once("vendor/autoload.php");
require_once("router/Router.class.php");

define("CONTROLLERS_PATH", "controllers/");

$router = new Router();
$router->loadRoutes(CONTROLLERS_PATH);
$router->matchRoute($_SERVER['REQUEST_URI']);

?>