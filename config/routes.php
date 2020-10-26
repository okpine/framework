<?php

use Demo\Framework\Routing\RouteGroup;
use Demo\Framework\Routing\Router;


return function(Router $router) {
    $router->get('/', '\Demo\App\Controllers\PageController::home')
        ->setName('home');
};
