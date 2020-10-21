<?php
namespace Demo\Framework\Foundation;

class CallableResolver
{
    public function resolve($toResolve)
    {
        if (is_callable($toResolve)) {
            return $toResolve;
        }
    }
}
