<?php
namespace Demo\Framework\Foundation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        container()->set(\Psr\Http\Message\ServerRequestInterface::class, $request);
        /** @var \Demo\Framework\Routing\Route */
        $route = $request->getAttribute('route');
        return container()->call($route->getHandler());
    }

}