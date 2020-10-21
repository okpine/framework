<?php
namespace Demo\Framework\Routing;

use Demo\Framework\Foundation\CallableResolver;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

use function Demo\Framework\Foundation\container;

class RouteGroup
{
    private $prefix;

    private $callback;

    protected $middleware = [];

    public function __construct($prefix, $callback)
    {
        $this->prefix = $prefix;
        $this->callback = $callback;
    }

    public function addMiddleware($middleware)
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function collectRoutes(Router $router)
    {
        $callable = container()->call([CallableResolver::class, 'resolve'], [$this->callback]);
        $callable($router);
        return $this;
    }
}
