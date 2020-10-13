<?php
namespace Demo\Framework\Routing;

class Route
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string Uri path
     */
    private $uri;

    /**
     * @var callable
     */
    private $handler;


    public function __construct($method, $uri, $handler)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
    }

    public function match()
    {
        # code...
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHandler()
    {
        return $this->handler;
    }
}
