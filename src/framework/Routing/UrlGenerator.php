<?php
namespace Demo\Framework\Routing;

use FastRoute\RouteParser\Std;
use LogicException;
use Psr\Http\Message\UriFactoryInterface;

class UrlGenerator
{
    /**
     * @var Router
     */
    protected $router;

    protected $uriFactory;

    public function __construct(Router $router, UriFactoryInterface $uriFactory)
    {
        $this->router = $router;
        $this->uriFactory = $uriFactory;
    }

    /**
     * @param Route|string $route Route instance or route name
     * @param array $params Route params
     * @param array $queryParams
     * @param bool $absolute
     * @return string
     */
    public function routeUrl($route, array $params = [], array $queryParams = [], $absolute = true)
    {
        if (is_string($route)) {
            $route = $this->router->getNamedRoute($route);
        }
        $path = $this->patternPath($route->getPath(), $params);
        $uri = $this->uriFactory->createUri($path)->withQuery(http_build_query($queryParams));

        return $uri->__toString();
    }

    /**
     * Generate uri path
     * @return string uri path
     * @throws LogicException
     */
    public function patternPath(string $pattern, array $params = [])
    {
        $routeParser = new Std;
        // (Maybe store the parsed form directly)
        $routes = $routeParser->parse($pattern);

        // One route pattern can correspond to multiple routes if it has optional parts
        foreach ($routes as $route) {
            $url = '';
            $paramIdx = 0;
            foreach ($route as $part) {
                // Fixed segment in the route
                if (is_string($part)) {
                    $url .= $part;
                    continue;
                }

                // Placeholder in the route
                if ($paramIdx === count($params)) {
                    throw new LogicException('Not enough parameters given');
                }
                $url .= $params[$paramIdx++];
            }

            // If number of params in route matches with number of params given, use that route.
            // Otherwise try to find a route that has more params
            if ($paramIdx === count($params)) {
                return $url;
            }
        }

        throw new LogicException('Too many parameters given');
    }
}
