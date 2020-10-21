<?php
namespace Demo\Framework\Routing;

use FastRoute\RouteCollector;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

use function Demo\Framework\Foundation\path;
use function FastRoute\simpleDispatcher;

class Router
{
    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @var int
     */
    private $routeCounter = 0;

    /**
     * @var \FastRoute\Dispatcher
     */
    private $routeDispatcher;

    /**
     * @var string
     */
    protected $currentGroupPrefix = '';


    public function routeDispatcher()
    {
        if ($this->routeDispatcher) {
            return $this->routeDispatcher;
        }
        $fun = require path('config/routes.php');
        $fun($this);
        return $this->routeDispatcher = simpleDispatcher([$this, 'collectRoutes']);
    }


    public function collectRoutes(RouteCollector $routeCollector)
    {
        foreach ($this->routes as $id => $route) {
            $routeCollector->addRoute($route->getMethod(), $route->getUri(), $id);
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
                return $this->findRoute($routeInfo);
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


    public function findRoute(array $routeInfo)
    {
        $id = $routeInfo[1];
        $route = $this->routes[$id];
        $route->setArguments($routeInfo[2]);
        return $route;
    }


    public function group($prefix, $callback)
    {
        $previousGroupPrefix = $this->currentGroupPrefix;
        $this->currentGroupPrefix = $previousGroupPrefix . $prefix;
        $routeGroup = new RouteGroup($this->currentGroupPrefix, $callback);
        $routeGroup->collectRoutes($this);
        $this->currentGroupPrefix = $previousGroupPrefix;
        return $routeGroup;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $route
     * @param mixed  $handler
     * @return Route
     */
    public function request($httpMethod, $route, $handler)
    {
        $id = 'route_' . $this->routeCounter++;
        $route = new Route($httpMethod, $this->currentGroupPrefix . $route, $handler);
        $route->setId($id);
        $this->routes[$id] = $route;
        return $route;
    }

    public function get($route, $handler)
    {
        return $this->request('GET', $route, $handler);
    }

    public function post($route, $handler)
    {
        return $this->request('POST', $route, $handler);
    }

    public function redirect($from, $to, int $status = 302)
    {
        # code...
    }

    public function view($template, $parameters)
    {
        # code...
    }
}
