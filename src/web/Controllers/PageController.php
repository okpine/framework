<?php
namespace Demo\App\Controllers;

use Demo\Framework\Foundation\Env;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

use function Demo\Framework\Foundation\env;
use function Demo\Framework\Foundation\response;

class PageController
{
    public function about($name, ServerRequestInterface $req)
    {
        dump(func_get_args());
        dump(env('APP_ENV'));
        return response('about');
    }
}
