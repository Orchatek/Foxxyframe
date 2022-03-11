<?php

if (!defined("APP_PATH")) {
    die("No direct call allowed");
}

// import sessions
require_once APP_PATH . "/vendor/autoload.php";

// import sessions
require_once APP_PATH . "/bootstrap/session.php";

// import functions
require_once APP_PATH . "/bootstrap/functions.php";

// import configs
require_once APP_PATH . "/bootstrap/configs.php";

// import routes
require_once APP_PATH . "/bootstrap/routes.php";
