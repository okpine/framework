<?php
namespace Demo\App\Controllers;

use Nyholm\Psr7\Response;

class PageController
{
    public function about()
    {
        $response = new Response();
        $response->getBody()->write("About");
        return $response;
    }
}
