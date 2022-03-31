<?php

namespace App\Controllers;

class WelcomeController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function __invoke()
    {
        echo $this->blade->run('index');
    }
}
