<?php

namespace App\Controllers;

class WelcomeController extends BaseController
{
    public function __invoke()
    {
        echo $this->twig->render('index.twig');
    }
}
