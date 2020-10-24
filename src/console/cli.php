<?php

use DI\Container;
use DI\ContainerBuilder;

use function DI\create;
use function DI\value;

$projectDir = dirname(__DIR__, 2);

require $projectDir.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($projectDir);
$dotenv->load();

dump(getenv('APP_ENV'));
dump($_ENV);
dump($_SERVER['APP_ENV']);