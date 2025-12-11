<?php

namespace app\Middleware;

use app\Core\Redirect;
use app\Core\Token;
/**
 *   - Redireciona para a dashboard quando acessa um rota especifica em que contem esse Middleware.
 *   - Middleware tem utilidade quando o usuario estive autenticado não acessar as rota de login e register ( e outras rotas caso necessario)
 */
class RedirectIfAuthenticatedMiddleware 
{
    public function handle($req, callable $next) {

        if (Token::validate($req->get_auth_token())) {
            Redirect::to('/dashboard');
        }

        return $next($req);
    }
}


