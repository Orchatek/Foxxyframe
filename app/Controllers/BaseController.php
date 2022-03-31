<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;
use Rakit\Validation\Validator;
use Twig\Environment;

abstract class BaseController
{
    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * @var Validator
     */
    protected Validator $validator;

    /**
     * @var BladeOne
     */
    protected BladeOne $view;

    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->view = $this->viewEngine();
        $this->validator = new Validator();
    }

    private function viewEngine(): BladeOne
    {
        $templatePath = APP_PATH . "/app/Views";
        $templateCache = APP_PATH . "/storage/cache";

        return (new BladeOne($templatePath, $templateCache, BladeOne::MODE_DEBUG));
    }
}
