<?php
namespace Demo\Framework\Foundation;

function app()
{
    return WebApplication::getInstance();
}

function container()
{
    return app()->getContainer();
}

function get($entry)
{
    return container()->get($entry);
}

function make($name, array $parameters = [])
{
    return container()->make($name, $parameters);
}

function path($relativePath = '')
{
    return app()->getProjectDir().($relativePath ? DIRECTORY_SEPARATOR.$relativePath : $relativePath);
}

function response($content = '', $status = 200)
{
    /** @var \Psr\Http\Message\ResponseFactoryInterface */
    $factory = get(\Psr\Http\Message\ResponseFactoryInterface::class);
    $response = $factory->createResponse($status);
    $response->getBody()->write($content);
    return $response;
}

function jsonResponse($data = '', $status = 200)
{
    return response(json_encode($data))
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);;
}

function redirect($url = '/', $status = 302)
{
    return response()
        ->withHeader('Location', $url)
        ->withStatus($status);
}


/**
 * Gets the value of an environment variable.
 *
 * @param  string  $key
 * @param  mixed  $default
 * @return mixed
 */
function env($key)
{
return get(Env::class)->get($key);
}

