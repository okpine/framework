<?php

use Demo\Framework\Routing\Router;

use function Demo\Framework\Foundation\response;

return function(Router $r) {
    $r->group('/page', function(Router $r){
        $r->get('/home', function(){
            return response("Hello Home");
        })->setName('home');
        $r->get('/about/{name}', [\Demo\App\Controllers\PageController::class, 'about'])->setName('about');
    });




    $r->request('GET', '/users', 'get_all_users_handler');
    // {id} must be a number (\d+)
    $r->request('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->request('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
};
