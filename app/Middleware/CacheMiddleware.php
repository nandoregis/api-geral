<?php

namespace app\Middleware;

class CacheMiddleware {
    public function handle($req, callable $next) {
        
        /**
         *  Add code of cache
         * 
         */


        return $next($req);
    }
}