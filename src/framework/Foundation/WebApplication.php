<?php
namespace Demo\Framework\Foundation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class WebApplication
{
    /**
     * @var static
     */
    protected static $instance;

    private $projectDir;

    private $container;

    private $middlewareDispatcher;


    public function __construct($projectDir = null)
    {
        if ($projectDir) {
            $this->setProjectDir($projectDir);
        }
        static::setInstance($this);
    }


    public function run()
    {
        $this->boot();
        $request = $this->container->get(ServerRequestInterface::class);
        $response = $this->middlewareDispatcher->handle($request);
        $this->sendResponse($response);
    }

    public function boot()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions(path('config/main.php'));
        $container = $builder->build();
        $this->setContainer($container);

        $this->middlewareDispatcher = new MiddlewareDispatcher();
        $middleware = require path('config/middleware.php');
        foreach ($middleware as $m) {
            $this->middlewareDispatcher->add($m);
        }
    }

    public function getProjectDir()
    {
        return $this->projectDir;
    }

    public function setProjectDir($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public static function setInstance($instance)
    {
        return static::$instance = $instance;
    }

    public function sendResponse(ResponseInterface $response)
    {
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}
