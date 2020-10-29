<?php
use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;


$projectDir = dirname(__DIR__);

return [
    \Psr\Log\LoggerInterface::class => autowire(\Monolog\Logger::class)->constructor('App Log')->method('pushHandler', create(\Monolog\Handler\StreamHandler::class)->constructor($projectDir.'/var/logs/app.log')),
    \Psr\Http\Message\ServerRequestFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
    \Psr\Http\Message\RequestFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
    \Psr\Http\Message\ResponseFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
    \Psr\Http\Message\UriFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
    \Psr\Http\Message\StreamFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
    \Psr\Http\Message\UploadedFileFactoryInterface::class => get(\Nyholm\Psr7\Factory\Psr17Factory::class),
];