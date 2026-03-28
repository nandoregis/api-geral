<?php

namespace app\Middleware;

use app\Core\HttpCode;
use app\Factory\Response;
use app\Service\JWT;
use app\View\ApiView;
use DateTime;
use DateTimeZone;

/**
 *  Middleware para verificar se usuario está com token de autenticação.
 */
class AuthMiddleware {

    private const HEADER_NAME = 'Authorization';


    public function handle(object $req, callable $next) 
    {   
        $token = $this->extractToken($req);
        
        if(!$token) $this->unauthorizedResponse('Token não encontrado');

        $payload = (new JWT)->decode($token);

        if(!isset($payload)) $this->unauthorizedResponse('Token inválido');

        if( ( new JWT )->isTokenExpired($token) ) $this->unauthorizedResponse('Token expirado');

        $req->authTokenDecoded = $payload;
        
        return $next($req);
    }


    private function extractToken(object $req): string | null
    {
        $header = $req->get_header(self::HEADER_NAME);

        if(empty($header)) return null;

        $partsHeader = explode(' ', $header);

        if(strtolower($partsHeader[0]) !== 'bearer' || count($partsHeader) !== 2) return null;

        $token = trim($partsHeader[1]);
        return $token !== '' ? $token : null;
    }
    
    private function unauthorizedResponse(string $message)
    {
        $response = new ApiView();
        $response->setStatus(HttpCode::UNAUTHORIZED)
        ->setData(Response::error(HttpCode::UNAUTHORIZED, $message))
        ->send();
        exit;
    }
    
    
}
