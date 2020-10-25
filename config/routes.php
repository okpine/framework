<?php

use Demo\Framework\Routing\RouteGroup;
use Demo\Framework\Routing\Router;

use function Demo\Framework\Foundation\response;

return function(Router $router) {
    $router->get('/', [\Demo\App\Controllers\PageController::class, 'home'])
            ->setName('home')
            ->addMiddleware([
                \Demo\App\Middleware\BeforeMiddleware::class,
                \Demo\App\Middleware\AfterMiddleware::class,
            ]);
    $router->group('/page', function(RouteGroup $group){
        $group->get('/home', function(){
            return response("Hello Home");
        })->setName('home');
        $group->get('/about/{name}/', [\Demo\App\Controllers\PageController::class, 'about'])
            ->setName('about')
            ->addMiddleware([
                \Demo\App\Middleware\BeforeMiddleware::class,
                \Demo\App\Middleware\AfterMiddleware::class,
            ]);

        $group->group('/post', function(RouteGroup $group){
            $group->get('/view', function(){
                return response("Post View");
            })->setName('home');
            $group->group('/aaa', function(RouteGroup $group){
                $group->get('/bbb', function(){
                    return response("Post bbb");
                })->setName('home');
                $group->group('/ccc', function(RouteGroup $group){
                    $group->get('/ddd', function(){
                        return response("Post ddd");
                    })->setName('home');
                });
            });
        })->middleware([
            \Demo\App\Middleware\BeforeMiddleware::class,
            \Demo\App\Middleware\AfterMiddleware::class,
        ]);
    })->middleware([
        \Demo\App\Middleware\BeforeMiddleware::class,
        \Demo\App\Middleware\AfterMiddleware::class,
    ]);




    $router->request('GET', '/users', 'get_all_users_handler');
    // {id} must be a number (\d+)
    $router->request('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $router->request('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
};
