<?php

use DI\Container;
use DI\ContainerBuilder;

use function DI\create;
use function DI\value;

$projectDir = dirname(__DIR__, 2);

require $projectDir.'/vendor/autoload.php';

function joinPath(...$paths)
{
    $result = '';
    foreach ($paths as $path) {
        if (substr($result, -1) === '/' && '/' === $path[0]) {
            $result .= ltrim($path, '/');
        } else {
            $result .= $path;
        }
        dump($result);
    }
    return $result;
}

$a = joinPath('/', '/page', '/home');\
dump($a);