<?php

namespace app\Core;

class Pipeline
{

    public static function pip(array $middlewares, callable $handler): callable {
        $next = $handler;
        foreach (array_reverse($middlewares) as $m) {
            $next = fn($req) => $m->handle($req, $next);
        }
        return $next;
    }

}