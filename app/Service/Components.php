<?php

namespace app\Service;

class Components
{

    private ?string $template = null;
    private array $variables = [];

    /**
     * Carrega o template HTML
     */

    public function load(string $path): self
    {
        $base = dirname(__DIR__, 2) . "/app/$path";
        $path = $base;

        if(!isset($path))throw new \Exception("Arquivo não encontrado!");
        
        if (!file_exists($path)) throw new \Exception("Template não encontrado: {$path}");

        $this->template = file_get_contents($path);

        return $this;
    }

    /**
     * Define variáveis para substituir
     */
    public function set(string|array $key, ?string $value = null): self
    {
        if (is_array($key)) 
        {

            foreach ($key as $k => $v) $this->variables[$k] = $v;

        } else $this->variables[$key] = $value ?? '';
        
        return $this;
    }

    /**
     * Substitui todas as variáveis no template
     */
    public function render()
    {
        if (empty($this->template)) throw new \Exception("Nenhum template carregado.");
        
        return preg_replace_callback('/\{@(\w+)\}/', function ($matches) {
            $key = $matches[1];
            return $this->variables[$key] ?? '';
        }, $this->template);

    }
    
}