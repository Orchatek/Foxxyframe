<?php

use Bramus\Router\Router;
use Rakit\Validation\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

if (!defined("APP_PATH")) {
    die("No direct call allowed");
}

/**
 * ================+
 * System Configurations
 * ================+
 */
const APP_NAME = 'Kwestion Framework';
define("APP_URL", get_server_url());

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

/**
 * ================+
 * System Validation Configurations
 * ================+
 */

// validator
$validator = new Validator();

