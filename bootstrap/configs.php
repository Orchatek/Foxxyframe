<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

if (!defined("APP_PATH")) {
    die("No direct call allowed");
}

/**
 * ================+
 * System Configurations
 * ================+
 */
const APP_NAME = 'Kwestion Framework';
const APP_DETAILS = [
    'APP_NAME' => APP_NAME,
    'APP_ADDRESS' => 'Address of the company',
    'APP_EMAIL' => 'email@info.com',
    'APP_PHONE' => 'Phone Number',
];

define("APP_URL", get_server_url('localhost','8081'));

// custom flash messages
const FLASH = 'FLASH_MESSAGES';
const FLASH_ERROR = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';

/**
 * ================+
 * Twig Configurations Configurations
 * ================+
 */

const TEMPLATE_PATH = APP_PATH . "/app/Views";
const TEMPLATE_CACHE_PATH = APP_PATH . "/storage/cache";

// twig configurations
$twigLoader = new FilesystemLoader(TEMPLATE_PATH);
$twig = new Environment($twigLoader, [
    'cache' => TEMPLATE_CACHE_PATH,
    'always_reload' => true,
    'debug' => true,
]);

$twig->addFunction(new TwigFunction('site_url', 'site_url'));
$twig->addFunction(new TwigFunction('csrf_field', 'get_csrf_field'));
$twig->addFunction(new TwigFunction('flash', 'flash'));
$twig->addFunction(new TwigFunction('config', static function ($value) {
    return APP_DETAILS[$value];
}));
