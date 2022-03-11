<?php

use Bramus\Router\Router;

define("APP_PATH", dirname(__FILE__, 2));

// import composer
require_once APP_PATH . "/vendor/autoload.php";

// init the router
$router = new Router();

// import bootstrap
require_once APP_PATH . "/bootstrap/bootstrap.php";

// run the router
$router->run();
