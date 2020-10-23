<?php
namespace Demo\Framework\Routing;

use Demo\Framework\Foundation\CallableResolver;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

use function Demo\Framework\Foundation\container;

class RouteGroup
{
    use RouteTrait;


    /**
     * @var Router
     */
    protected $router;


    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array
     */
    protected $middleware = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function middleware($middleware)
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function collectRoutes()
    {
        /** @var callable $callable */
        $callable = container()->call([CallableResolver::class, 'resolve'], [$this->callback]);
        $callable($this);
        $this->router->collectRoutes($this->routeGroups);
        return $this;
    }



    public function group($prefix, $callback)
    {
        $prefix = $this->router->joinPath($this->prefix, $prefix);
        $routeGroup = $this->router->group($prefix, $callback);
        $this->addRouteGroup($routeGroup);
        return $routeGroup;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $route
     * @param mixed  $handler
     * @return Route
     */
    public function request($httpMethod, $uriPath, $handler)
    {
        $uriPath = $this->router->joinPath($this->prefix, $uriPath);
        $route = $this->router->request($httpMethod, $uriPath, $handler);
        $this->addRoute($route);
        return $route;
    }


    public function getCallback()
    {
        return $this->callback;
    }


    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }
}
