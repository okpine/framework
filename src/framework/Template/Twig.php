<?php
namespace Demo\Framework\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use function Demo\Framework\Foundation\path;

class Twig
{
    protected $loader;

    protected $environment;

    public function __construct()
    {
        $loader = new FilesystemLoader([], path());
        $loader->addPath('templates/frontend', 'frontend');
        $loader->addPath('templates/backend', 'backend');
        $this->loader = $loader;
        $this->environment = new Environment($loader, [
            'debug' => true,
            'cache' => path('var/twig-caches'),
        ]);
    }


    /**
     * @param string|TemplateWrapper $template The template name
     */
    public function render($template, array $context = []): string
    {
        return $this->environment->render($template, $context);
    }


    /**
     * @param string|TemplateWrapper $template The template name
     * @param string $name The block name
     */
    public function renderBlock($template, string $name, array $context = []): string
    {
        return $this->environment->load($template)->renderBlock($name, $context);
    }

}
