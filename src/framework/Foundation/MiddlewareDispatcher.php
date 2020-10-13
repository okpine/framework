<?php
namespace Demo\Framework\Foundation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

class MiddlewareDispatcher implements RequestHandlerInterface
{
    /**
     * @var string[]
     */
    private $middleware = [];

    /**
     * @var RouteHandler
     */
    private $routeHandler;


    public function __construct(RouteHandler $routeHandler)
    {
        $this->routeHandler = $routeHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middleware)) {
            return $this->routeHandler->handle($request);
        }
        $middleware = array_shift($this->middleware);
        $middleware = get($middleware);
        return $middleware->process($request, $this);
    }


    public function add($middleware)
    {
        $this->middleware[] = $middleware;
        return $this;
    }
}
