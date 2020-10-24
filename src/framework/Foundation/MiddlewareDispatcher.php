<?php
namespace Demo\Framework\Foundation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareDispatcher implements RequestHandlerInterface
{
    /**
     * @var string[]
     */
    private $middleware = [];

    /**
     * @var RequestHandlerInterface
     */
    private $fallbackHandler;


    public function __construct(RequestHandlerInterface $fallbackHandler)
    {
        $this->fallbackHandler = $fallbackHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middleware)) {
            return $this->fallbackHandler->handle($request);
        }
        $middleware = array_shift($this->middleware);
        $middleware = get($middleware);
        return $middleware->process($request, $this);
    }


    /**
     * @param string|string[] $middleware
     */
    public function addMiddleware($middleware)
    {
        $middleware = is_array($middleware) ? $middleware : func_get_args();
        array_push($this->middleware, ...$middleware);
        return $this;
    }

    /**
     * @param string|string[] $middleware
     */
    public function prependMiddleware($middleware)
    {
        $middleware = is_array($middleware) ? $middleware : func_get_args();
        array_unshift($this->middleware, ...$middleware);
        return $this;
    }
}
