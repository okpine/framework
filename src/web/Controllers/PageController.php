<?php
namespace Demo\App\Controllers;

use Demo\Framework\Foundation\Env;
use Demo\Framework\Routing\Router;
use Demo\Framework\Routing\UrlGenerator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

use function Demo\Framework\Foundation\env;
use function Demo\Framework\Foundation\response;
use function Demo\Framework\Foundation\view;

class PageController
{
    public function home(ServerRequestInterface $request)
    {
        dump($request);
        return view("@frontend/home.twig");
    }

    public function about(UrlGenerator $url)
    {
        dump($url->routeUrl('about', [], ['name'=>'Tom']));
        return response('about');
    }
}
