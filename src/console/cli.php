<?php

use DI\Container;
use DI\ContainerBuilder;

use function DI\create;
use function DI\value;

$projectDir = dirname(__DIR__);

require __DIR__.'/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($projectDir . '/config/php-di.php');
$c = $builder->build();

var_dump($c->get(\App\Demo\GithubProfile::class));
