<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use Twig\Environment;

abstract class BaseController
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Validator
     */
    protected $validator;

    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->validator = $GLOBALS['validator'];
    }
}
