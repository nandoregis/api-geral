<?php

namespace app\Factory;

class Response {
    public int $status = 200;
    public array $headers = [];
    public string $body = '';

    public function send() {
        http_response_code($this->status);
        foreach ($this->headers as $k => $v) {
            header("$k: $v");
        }
        echo $this->body;
    }


    public static function error( int $code, string | array $message ) : array
    {
        return self::base(true, $code, $message);
    }

    public static function success( int $code, string | array $message, array $data ) : array
    {
        return self::base(false, $code, $message, $data);
    }

    private static function base( bool $error, int $code, string | array  $message, array $data = []) : array
    {
        return [

            'error' => $error,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
    
}