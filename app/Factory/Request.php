<?php

namespace app\Factory;

use app\Core\Token;

class Request
{
    public array $headers;
    public array $body;
    private array $authTokenDecoded;
    private array $vars_uri;

    public string $httpUri;
    public string $method;
  
    public function __construct()
    {
        $this->headers = getallheaders();
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $this->httpUri     = strtok($_SERVER['REQUEST_URI'], '?');
        $this->authTokenDecoded = [];
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

    public function get_header(string $key)
    {
        return $this->headers[$key] ?? null;
    }

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

    public function get_token_decoded(): array
    {
        return $this->authTokenDecoded;
    }

    public function uri(string $key, $default = null)
    {
        return $this->vars_uri[$key] ?? $default;
    }

    public function set_var(string $key, string $value) {
        $this->vars_uri[$key] = $value;
    }


}
