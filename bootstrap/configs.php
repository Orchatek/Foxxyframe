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
const APP_NAME = 'FoxxyFrame';
const APP_DETAILS = [
    'APP_NAME' => APP_NAME,
    'APP_ADDRESS' => 'Address of the company',
    'APP_EMAIL' => 'info@assetsrepo.com',
    'APP_PHONE' => 'Phone Number',
];

define("APP_URL", get_server_url());

// custom flash messages
const FLASH = 'FLASH_MESSAGES';
const FLASH_ERROR = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';
