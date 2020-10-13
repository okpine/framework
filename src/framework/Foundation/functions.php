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


