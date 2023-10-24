<?php

require_once("vendor/autoload.php");
require_once("router/Router.class.php");

define("CONTROLLERS_PATH", "controllers/");

$router = new Router();
$router->loadRoutes(CONTROLLERS_PATH);
$router->matchRoute(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

?>