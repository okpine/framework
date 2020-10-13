<?php
namespace Demo\App\Controllers;

use Nyholm\Psr7\Response;

use function Demo\Framework\Foundation\response;

class PageController
{
    public function about()
    {
        return response('about');
    }
}
