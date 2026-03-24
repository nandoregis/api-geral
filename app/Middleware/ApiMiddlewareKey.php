<?php
namespace app\Middleware;

use app\Core\HttpCode;

/**
 * Middleware para verificar se a requisição possui uma API key válida.
 */
class ApiKeyMiddleware
{
    private const HEADER_NAME = 'X-Api-Key';

    public function handle($req, callable $next)
    {
        $apiKey = $req->get_header(self::HEADER_NAME);

        if (!$this->isValid($apiKey)) {
            http_response_code(HttpCode::UNAUTHORIZED);
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => false,
                'code'    => HttpCode::UNAUTHORIZED,
                'message' => 'API key inválida ou ausente.'
            ]);
            exit;
        }

        return $next($req);
    }

    private function isValid(?string $apiKey): bool
    {
        if (is_null($apiKey) || $apiKey === '') {
            return false;
        }

        return $apiKey === API_KEY;
    }
}