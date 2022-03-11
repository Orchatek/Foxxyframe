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

// contact
router()->get('contact', 'App\Controllers\ContactController@index');
router()->post('contact', 'App\Controllers\ContactController@store');
router()->post('send', 'App\Controllers\ContactController@store');

/**
 * ================+
 * 404 route
 * ================+
 */
router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
    echo $GLOBALS['twig']->render('404.twig');
});
