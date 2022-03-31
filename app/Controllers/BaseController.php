<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;
use Rakit\Validation\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

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
    protected BladeOne $blade;

    public function __construct()
    {
        $this->twig = $this->twigViewEngine();
        $this->blade = $this->bladeViewEngine();
        $this->validator = new Validator();
    }

    /**
     * return a blade view engine
     * @return BladeOne
     */
    private function bladeViewEngine(): BladeOne
    {
        $templatePath = APP_PATH . "/app/Views";
        $templateCache = APP_PATH . "/storage/cache";

        return (new BladeOne($templatePath, $templateCache, BladeOne::MODE_DEBUG));
    }

    /**
     * return a twig view engine
     * @return Environment
     */
    private function twigViewEngine(): Environment
    {

        $template_path = APP_PATH . "/app/Views";
        $template_cache_path = APP_PATH . "/storage/cache";

        // twig configurations
        $twigLoader = new FilesystemLoader($template_path);
        $twig = new Environment($twigLoader, [
            'cache' => $template_cache_path,
            'always_reload' => true,
            'debug' => true,
        ]);

        $twig->addFunction(new TwigFunction('site_url', 'site_url'));
        $twig->addFunction(new TwigFunction('csrf_field', 'get_csrf_field'));
        $twig->addFunction(new TwigFunction('flash', 'flash'));
        $twig->addFunction(new TwigFunction('config', static function ($value) {
            return APP_DETAILS[$value];
        }));

        return $twig;
    }
}
