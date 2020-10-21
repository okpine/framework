<?php
namespace Demo\Framework\Routing;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function Demo\Framework\Foundation\container;

class RouteHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var \Demo\Framework\Routing\Route */
        $route = $request->getAttribute('route');
        return $route->run($request);
    }

}