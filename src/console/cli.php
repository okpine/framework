<?php

use DI\Container;
use DI\ContainerBuilder;

use function DI\create;
use function DI\value;

$projectDir = dirname(__DIR__, 2);

require $projectDir.'/vendor/autoload.php';


function addMiddleware($middleware)
{
    $middleware = is_array($middleware) ? $middleware : func_get_args();
    $a = ['aaa', 'AAA'];
    array_unshift($a, ... $middleware);
    return $a;
}


$a = addMiddleware('bbbb' ,'BBBB');

dump($a);