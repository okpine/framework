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


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middleware)) {
            throw new RuntimeException("Middleware does not exist");
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
