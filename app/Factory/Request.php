<?php

namespace app\Factory;

class Request {


    public array $headers;
    public array $body;
    public string $uri;
    public string $method;
    private string $autToken;

    public function __construct() {
        $this->headers = getallheaders();
        $this->body = $_POST ?: $_GET; 
        $this->uri = strtok($_SERVER["REQUEST_URI"], '?');
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->autToken = isset($_SESSION[COOKIE_NAME]) ? $_SESSION[COOKIE_NAME] : '';
    } 

    public function input(string $key, $default = null) 
    {
        return $this->body[$key] ?? $default;
    }

    public function get(string $key, $default = null) 
    {
        return $this->getRequest()[$key] ?? $default;
    }

    public function post(string $key, $default = null) 
    {
        return $this->postRequest()[$key] ?? $default;
    }

    public function get_auth_token()
    {
        return $this->autToken;
    }

    public function exist_post()
    {
        if( $this->postRequest() ) return true;
        return false;
    }
    
    private function getRequest(): array 
    {
        return $this->method === 'GET' ? $_GET : [];
    }

    private function postRequest(): array 
    {
        return $this->method === 'POST' ? $_POST : [];
    }
    

}