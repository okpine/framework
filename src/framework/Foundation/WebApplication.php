<?php
namespace Demo\Framework\Foundation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WebApplication implements RequestHandlerInterface
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
        $this->middlewareDispatcher = new MiddlewareDispatcher();
        static::setInstance($this);
    }


    public function run()
    {
        $this->boot();
        $request = $this->createServerRequest();
        $response = $this->handle($request);
        $this->sendResponse($response);
    }

    public function boot()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions($this->getProjectDir() . '/config/main.php');
        $container = $builder->build();
        $this->setContainer($container);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = require $this->getProjectDir() . '/config/middleware.php';
        foreach ($middleware as $m) {
            $this->middlewareDispatcher->add($m);
        }
        return $this->middlewareDispatcher->handle($request);
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

    public function createServerRequest()
    {
        $factory = $this->getContainer()->get(ServerRequestFactoryInterface::class);
        return $factory->createServerRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }


    public function sendResponse(ResponseInterface $response)
    {
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}
