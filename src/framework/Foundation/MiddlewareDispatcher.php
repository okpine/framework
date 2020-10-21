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
        foreach ((array)$middleware as $mw) {
            $this->middleware[] = $mw;
        }
        return $this;
    }
}
