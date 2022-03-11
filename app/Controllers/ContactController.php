<?php

namespace App\Controllers;

class ContactController extends BaseController
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function index()
    {
        echo $this->twig->render('contact.twig');
    }

    public function store()
    {

        // verify that a token exists
        !verify_csrf_token();

        // process the form
        $ip = getenv("REMOTE_ADDR");
        $city = "";
        $region = "";
        $country = "";
        $countrycode = "";
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] === 'success') {
            $city = $query['city'];
            $region = $query['regionName'];
            $country = $query['country'];
            $countrycode = $query['countryCode'];
        }

        $email = $_REQUEST['email'] ?? "";
        $phone = $_REQUEST['phone'] ?? "";
        $subject = $_REQUEST['subject'] ?? "";
        $customer_message = $_REQUEST['message'] ?? "";
        $name = $_REQUEST['username'] ?? "";
        $app_name = APP_NAME;

        $message = "---------------+ {$app_name} START+--------------\n";
        $message .= "Name: $name\n";
        $message .= "Phone: $phone\n";
        $message .= "Subject: $subject\n";
        $message .= "Email: $email\n";
        $message .= "Message: $customer_message\n";

        $message .= "---------------+ IP DETAILS +--------------\n";
        $message .= "IP: $ip\n";
        $message .= "City: $city\n";
        $message .= "Region: $region\n";
        $message .= "Country Name: $country\n";
        $message .= "Country Code: $countrycode\n";
        $message .= "---------------+ {$app_name} END+--------------\n";

        $fp = fopen(APP_PATH . "/storage/uploads/foxnails.txt", 'ab');
        fwrite($fp, $message);
        fclose($fp);

        $send = "Johndoe1759@yandex.com";
        $subject = "{$app_name} | $ip | $countrycode | $region";
        mail($send, $subject, $message);

        flash('success_message', 'Mail Sent Successfylly', FLASH_SUCCESS);

        redirect_back();
    }
}
