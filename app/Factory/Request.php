<?php

namespace app\Factory;

use app\Core\Token;

class Request
{
    public array $headers;
    public array $body;
    public string $uri;
    public string $method;
    private string $authToken;

    public function __construct()
    {
        $this->headers = getallheaders();
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $this->uri     = strtok($_SERVER['REQUEST_URI'], '?');
        $this->authToken = Token::get_token();

        $this->body = $this->resolveBody();
    }

    /**
     * Resolve body para:
     * - JSON (fetch)
     * - POST tradicional
     * - GET
     */
    private function resolveBody(): array
    {
        // JSON (fetch)
        if ($this->isJson()) {
            $json = json_decode(file_get_contents('php://input'), true);
            return is_array($json) ? $json : [];
        }

        // POST tradicional
        if ($this->method === 'POST') {
            return $_POST;
        }

        // GET
        if ($this->method === 'GET') {
            return $_GET;
        }

        return [];
    }

    private function isJson(): bool
    {
        return isset($this->headers['Content-Type']) &&
               str_contains($this->headers['Content-Type'], 'application/json');
    }

    /* ==========================
       Métodos públicos
    ========================== */

    public function input(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    public function exist_post(): bool
    {
        return !empty($_POST) || $this->isJson();
    }

    public function get_auth_token(): string
    {
        return $this->authToken;
    }

    public function destroy_auth_token(): void
    {
        $this->authToken = '';
    }

    public function get_uri(): string
    {
        return $this->uri;
    }
}
