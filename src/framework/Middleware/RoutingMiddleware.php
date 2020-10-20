<?php
namespace Demo\Framework\Middleware;

use Demo\Framework\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

use function Demo\Framework\Foundation\container;
use function Demo\Framework\Foundation\get;
use function Demo\Framework\Foundation\path;

class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->router->match($request);
        $request = $request->withAttribute('route', $route);
        return $handler->handle($request);
    }

}
