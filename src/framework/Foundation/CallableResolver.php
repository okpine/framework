<?php
namespace Demo\Framework\Foundation;

use RuntimeException;

class CallableResolver
{
    public function resolve($toResolve)
    {
        if (is_string($toResolve) && strpos($toResolve, '@') !== false) {
            return explode('@', $toResolve, 2);
        }

        return $toResolve;
    }
}
