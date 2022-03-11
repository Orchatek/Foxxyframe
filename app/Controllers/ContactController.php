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
        echo "we are post data";
    }
}
