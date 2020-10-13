<?php

use Demo\Framework\Routing\Router;
use Nyholm\Psr7\Response;

return function(Router $router){

    $router->request('GET', '/home', function(){
        $response = new Response();
        $response->getBody()->write("Hello Home");
        return $response;
    });

    $router->request('GET', '/about', [\Demo\App\Controllers\PageController::class, 'about']);

    return $router;
};