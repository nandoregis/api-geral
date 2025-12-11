<?php

namespace app\Middleware;

use app\Core\Redirect;
use app\Core\Token;

/**
 *  - Middelware para desconectar autenticação. logout
 */
class RedirectIfLogoutMiddleware
{
    public function handle($req, callable $next) {

        if (Token::validate($req->get_auth_token())) {
            session_destroy();
            Redirect::to('/auth');
        }

        return $next($req);
    }
}


