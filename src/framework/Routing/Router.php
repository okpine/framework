<?php
namespace Demo\Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * Route[]
     */
    private $routes;

    public function match(ServerRequestInterface $request)
    {
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($request->getMethod() === $route->getMethod() && $request->getUri()->getPath() === $route->getUri()) {
                return $route;
            }
        }
    }

    public function request($method, $uri, $handler)
    {
        $this->routes[] = new Route($method, $uri, $handler);
        return $this;
    }
}
