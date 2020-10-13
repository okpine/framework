<?php
namespace Demo\App\Controllers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

use function Demo\Framework\Foundation\response;

class PageController
{
    public function about(ServerRequestInterface $req)
    {
        dump($req);
        return response('about');
    }
}
