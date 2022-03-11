<?php

use Bramus\Router\Router;

if (!defined("APP_PATH")) {
    die("No direct call allowed");
}

/**
 * ================+
 * Functions Definitions
 * ================+
 */

/**
 * setup the site url
 * @param string $url
 * @return string
 */
function site_url(string $url = "/"): string
{
    return rtrim(APP_URL, "/") . "/" . rtrim($url, "/");
}

/**
 * generate a csrf token
 * @return string
 * @throws Exception
 */
function get_csrf_token(): string
{
    $csrf_token = bin2hex(random_bytes(35));
    $_SESSION['token'] = $csrf_token;
    return $csrf_token;
}

/**
 * generate an input field with csrf token
 * @return string
 */
function get_csrf_field(): string
{
    try {
        $token = get_csrf_token();

    } catch (Exception $e) {
        die($e);
    }

    return "<input type=\"hidden\" name=\"token\" value=\"$token\">";
}

/**
 * used to check the csrf token
 * @return bool|void
 */
function verify_csrf_token()
{
    $token = post_input('token');

    if (!$token || !hash_equals($token, $_SESSION['token'])) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }

    return true;
}

/**
 * setup hidden fields
 * @param string $value
 * @param string $type
 * @return string
 */
function get_action_field(string $value = "default", string $type = "__action"): string
{
    return "<input type=\"hidden\" name=\"$type\" value=\"$value\">";
}

/**
 * filter the input strings
 * @param $name
 * @param int $constant
 * @param int $type
 * @return mixed
 */
function post_input($name, int $constant = FILTER_SANITIZE_STRING, int $type = INPUT_POST)
{
    return filter_input($type, $name, $constant);
}

/**
 * filter the input strings
 * @param $name
 * @param int $constant
 * @return mixed
 */
function get_input($name, int $constant = FILTER_SANITIZE_STRING)
{
    return filter_input(INPUT_GET, $name, $constant);
}

/**
 * redirect the user
 * @param string $dest
 * @return void
 */
function redirect(string $dest = "")
{
    if (!empty($dest)) {
        header("Location:" . $dest);
    }

    // quit the script from running anymore
    die("<h1> Redirect Error!</h1> Please kindly input the proper route");
}

// redirect back to where to came from
function redirect_back()
{
    redirect($_SERVER['HTTP_REFERER']);
}

/**
 * Create a flash message
 *
 * @param string $name
 * @param string $message
 * @param string $type
 * @return void
 */
function create_flash_message(string $name, string $message, string $type): void
{
    // remove existing message with the name
    if (isset($_SESSION[FLASH][$name])) {
        unset($_SESSION[FLASH][$name]);
    }
    // add the message to the session
    $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}


/**
 * Format a flash message
 *
 * @param array $flash_message
 * @return string
 */
function format_flash_message(array $flash_message): string
{
    return sprintf('<div class="alert alert-%s" style="padding: 10px;">%s</div>',
        $flash_message['type'],
        $flash_message['message']
    );
}

/**
 * Display a flash message
 *
 * @param string $name
 * @return void
 */
function display_flash_message(string $name): void
{
    if (!isset($_SESSION[FLASH][$name])) {
        return;
    }

    // get message from the session
    $flash_message = $_SESSION[FLASH][$name];

    // delete the flash message
    unset($_SESSION[FLASH][$name]);

    // display the flash message
    echo format_flash_message($flash_message);
}

/**
 * Display all flash messages
 *
 * @return void
 */
function display_all_flash_messages(): void
{
    if (!isset($_SESSION[FLASH])) {
        return;
    }

    // get flash messages
    $flash_messages = $_SESSION[FLASH];

    // remove all the flash messages
    unset($_SESSION[FLASH]);

    // show all flash messages
    foreach ($flash_messages as $flash_message) {
        echo format_flash_message($flash_message);
    }
}

/**
 * Flash a message
 *
 * @param string $name
 * @param string $message
 * @param string $type (error, warning, info, success)
 * @return void
 */
function flash(string $name = '', string $message = '', string $type = ''): void
{
    if ($name !== '' && $message !== '' && $type !== '') {
        // create a flash message
        create_flash_message($name, $message, $type);
    } elseif ($name !== '' && $message === '' && $type === '') {
        // display a flash message
        display_flash_message($name);
    } elseif ($name === '' && $message === '' && $type === '') {
        // display all flash message
        display_all_flash_messages();
    }
}

/**
 * get the current server with port number
 * @return string
 */
function get_server_url($name = "", $portNumber = ""): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on' || $_SERVER['HTTPS'] === '1')) ? 'https://' : 'http://';
    $server = $name ?? $_SERVER['SERVER_NAME'];
    if (empty($portNumber)) {
        $port = !empty($_SERVER['SERVER_PORT']) ? sprintf(":%s", $_SERVER['SERVER_PORT']) : "";
    } else {
        $port = ":" . $portNumber;
    }

    return $protocol . $server . $port;
}

/**
 * generate a random number
 * @return int|void
 */
function generate_rand_num()
{
    try {
        return random_int(1111111111, 9999999999);
    } catch (Exception $exception) {

    }
}

/**
 * @return array
 */
function mass_clean_fields(): array
{
    $fields = [];
    foreach ($_POST as $item => $value) {
        $fields[$item] = post_input($item);
    }

    // get important things
    $id = $fields['id'];
    $subaction = $fields['__sub_action'];

    // unset things not needed
    unset($fields['token'], $fields['__sub_action'], $fields['__action'], $fields['id']);

    $password = $fields['password'];
    if (!empty($password)) {
        $fields['password'] = bcrypt($password);
    } else {
        unset($fields['password']);
    }
    return array($fields, $id, $subaction);
}

/**
 * get the human time setup
 * @param $time
 * @param bool $convert
 * @return string|null
 */
function get_human_time($time, bool $convert = false)
{
    $time_difference = time() - ($convert ? strtotime($time) : $time);

    /** @noinspection InsufficientTypesControlInspection */
    if (1 > $time_difference) {
        return 'less than 1 second ago';
    }
    $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }

    return null;
}

/**
 * used to hash a password
 * @param $password
 * @return false|string|null
 */
function bcrypt($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Create Router instance
 * @return Router
 */
function router(): Router
{
    return $GLOBALS['router'];
}
