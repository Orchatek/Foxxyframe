<?php

namespace App\Controllers;

class ContactController extends BaseController
{
    public function index()
    {
        echo $this->twig->render('contact.twig');
    }

    public function store()
    {
        echo "we are post data";
    }
}
