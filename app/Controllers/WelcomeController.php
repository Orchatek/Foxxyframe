<?php

namespace App\Controllers;

class WelcomeController extends BaseController
{
    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function __invoke()
    {
        echo $this->twig->render('index.twig');
    }
}
