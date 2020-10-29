<?php

use Demo\Framework\Routing\RouteGroup;
use Demo\Framework\Routing\Router;


return function(Router $router) {
    $router->get('/', 'Demo\App\Controllers\PageController::home')
        ->setName('home');

    $router->get('/about', 'Demo\App\Controllers\PageController::about')
        ->setName('about');

    $router->post('/receive-data', 'Demo\App\Controllers\PageController::receiveData')->setName('receive-data');

};
