<?php
namespace Demo\Framework\Routing;

use FastRoute\RouteCollector;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

use function Demo\Framework\Foundation\path;
use function FastRoute\simpleDispatcher;

class Router
{
    use RouteTrait;


    /**
     * @var \FastRoute\Dispatcher
     */
    protected $routeDispatcher;


    public function routeDispatcher()
    {
        if ($this->routeDispatcher) {
            return $this->routeDispatcher;
        }
        $fun = require path('config/routes.php');
        $fun($this);
        foreach ($this->routeGroups as $group) {
            $group->buildRoutes();
        }

        return $this->routeDispatcher = simpleDispatcher([$this, 'addToFastRouteCollector']);
    }



    public function addToFastRouteCollector(RouteCollector $routeCollector)
    {
        foreach ($this->routes as $id => $route) {
            $routeCollector->addRoute($route->getMethod(), $route->getPath(), $id);
        }
    }


    /**
     * @return Route
     * @throws RuntimeException
     */
    public function match(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        $routeInfo = $this->routeDispatcher()->dispatch($request->getMethod(), rawurldecode($uri));
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::FOUND:
                $id = $routeInfo[1];
                $route = $this->routes[$id];
                $route->setArguments($routeInfo[2]);
                return $route;
                break;
            case \FastRoute\Dispatcher::NOT_FOUND:
                $exception = new RuntimeException('The requested resource could not be found. Please verify the URI and try again.');
                $exception->request = $request;
                throw $exception;
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $exception = new RuntimeException('Method not allowed. Must be one of: ' . implode(', ', $allowedMethods));
                $exception->request = $request;
                $exception->allowedMethods = $allowedMethods;
                throw $exception;
                break;
            default:
                throw new RuntimeException('An unexpected error occurred while performing routing.');
                break;
        }
    }

    /**
     * @var string $name Route Name
     */
    public function getNamedRoute(string $name)
    {
        foreach ($this->routes as $route) {
            if ($name === $route->getName()) {
                return $route;
            }
        }
        throw new RuntimeException('Named route does not exist for name: ' . $name);
    }

    public function request($httpMethod, $uriPath, $handler)
    {
        $route = new Route($httpMethod, $this->joinPath($this->prefix, $uriPath), $handler);
        $id = $this->routeId();
        $route->setId($id);
        $this->addRoute($route);
        return $route;
    }

    public function group($prefix, $callback)
    {
        $routeGroup = new RouteGroup($this);
        $id = $this->routeGroupId();
        $routeGroup->setId($id)->setPrefix($prefix)->setCallback($callback);
        $this->addRouteGroup($routeGroup);
        return $routeGroup;
    }


    /**
     * Generate new route id
     */
    public function routeId()
    {
        return 'route_' . count($this->routes);
    }

    /**
     * Generate new route group id
     */
    public function routeGroupId()
    {
        return 'route_group_' . count($this->routeGroups);
    }
}
