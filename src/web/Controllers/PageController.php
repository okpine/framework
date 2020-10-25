<?php
namespace Demo\App\Controllers;

use Demo\Framework\Foundation\Env;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

use function Demo\Framework\Foundation\env;
use function Demo\Framework\Foundation\response;
use function Demo\Framework\Foundation\view;

class PageController
{
    public function home()
    {
        return view("@frontend/home.twig");
    }

    public function about($name, ServerRequestInterface $req)
    {
       // setcookie('name', 'Tom', time()+60);
       // dump(php_uname());
        return response('about ' . $name);
    }
}
