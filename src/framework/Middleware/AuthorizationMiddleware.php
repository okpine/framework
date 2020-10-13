<?php
namespace Demo\Framework\Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (isset($_GET['p']) && $_GET['p'] == 123) {
            dump("Authorization Success!");
            return $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write("Authorization Failed!");
            return $response;
        }


    }
}
