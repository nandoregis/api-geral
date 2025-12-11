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
}