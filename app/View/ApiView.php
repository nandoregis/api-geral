<?php

namespace app\View;

use app\Factory\Response;

class ApiView
{
    private array $data = [];
    private int $status = 200;
    private array $headers = [];

    /**
     * Define dados da API
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Define status HTTP
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Adiciona header extra
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Renderiza e envia resposta JSON usando Response
     */
    public function send(?Response $response = null): void
    {
        $response = $response ?? new Response();

        $response->status = $this->status;
        $response->headers = array_merge(['Content-Type' => 'application/json; charset=utf-8'], $this->headers);
        $response->body = json_encode($this->data);

        $response->send();
    }
}
