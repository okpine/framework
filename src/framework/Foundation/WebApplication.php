<?php
namespace Demo\Framework\Foundation;

use Demo\Framework\Routing\RouteHandler;
use Psr\Http\Message\ResponseInterface;
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
        static::setInstance($this);
    }


    public function run()
    {
        $this->boot();
        $request = $this->createRequestFromGlobals();
        $response = $this->handle($request);
        $this->sendResponse($response);
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middlewareDispatcher->handle($request);
    }


    public function boot()
    {
        // container
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions(path('config/main.php'));
        $container = $builder->build();
        $this->setContainer($container);

        // middleware
        $this->middlewareDispatcher = new MiddlewareDispatcher(new RouteHandler());
        $middleware = require path('config/middleware.php');
        foreach ($middleware as $mw) {
            $this->middlewareDispatcher->addMiddleware($mw);
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

    public function createRequestFromGlobals()
    {
        /** @var \Nyholm\Psr7Server\ServerRequestCreator */
        $factory = get(\Nyholm\Psr7Server\ServerRequestCreator::class);
        $request = $factory->fromGlobals();
        $this->container->set(\Psr\Http\Message\ServerRequestInterface::class, $request);
        return $request;
    }

    public function sendResponse(ResponseInterface $response)
    {
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}
