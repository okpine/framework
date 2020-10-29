<?php
namespace Demo\App\Controllers;

use Demo\Framework\Foundation\Env;
use Demo\Framework\Routing\Router;
use Demo\Framework\Routing\UrlGenerator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

use function Demo\Framework\Foundation\env;
use function Demo\Framework\Foundation\get;
use function Demo\Framework\Foundation\path;
use function Demo\Framework\Foundation\redirect;
use function Demo\Framework\Foundation\response;
use function Demo\Framework\Foundation\view;

class PageController
{
    public function home(ServerRequestInterface $request, UrlGenerator $url)
    {
        $session_dir = path('var/sessions');
        session_save_path($session_dir);
        ini_set('session.serialize_handler', 'php_serialize');
        session_start();
       // $_SESSION['aa']['bb']['cc']['ddd'] = 12;
       // $_SESSION['AA']['BB'] = 456;
       dump($_SESSION);

        $data['url'] = $url->routeUrl('receive-data');
        return view("@frontend/home.twig", $data);
    }

    public function about(UrlGenerator $url)
    {
        dump($url->routeUrl('about', [], ['name'=>'Tom']));
        return response('about');
    }


    public function receiveData()
    {
        /** @var \Monolog\Logger */
        $logger = get(\Psr\Log\LoggerInterface::class);
        $logger->debug(var_export($_POST, true));
        return redirect('/');
    }
}
