<?php

if (!defined("APP_PATH")) {
    die("No direct call allowed");
}

/**
 * ================+
 * Routes Configurations
 * ================+
 */
router()->get('/', 'App\Controllers\WelcomeController@__invoke');

// add more routes here

/**
 * ================+
 * 404 route
 * ================+
 */
router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
    echo $GLOBALS['twig']->render('404.twig');
});
