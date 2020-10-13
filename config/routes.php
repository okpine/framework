<?php

use Demo\Framework\Routing\Router;
use Nyholm\Psr7\Response;

use function Demo\Framework\Foundation\response;

return function(Router $router){

    $router->request('GET', '/home', function(){
        return response("Hello Home");
    });

    $router->request('GET', '/about', [\Demo\App\Controllers\PageController::class, 'about']);

    return $router;
};