<?php

namespace app\View;

use Exception;

class View
{
    private string $baseDir;       // Diretório base do app
    private string $dir_path;
    private ?string $template = null;
    private array $variables = [];

    public function __construct(String $dir = null)
    {
        // Define o diretório base (app/)
        $this->baseDir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;

        if($dir) $this->dir_validation($dir);
    }


    public function dir(string $dir)
    {   
        
        $this->dir_validation($dir);
        return $this;
    }

    /**
     * Carrega um template/view
     */
    public function load(string $view): self
    {
        // $filePath = $this->baseDir . 'Modules/' .str_replace('/', DIRECTORY_SEPARATOR, $view);

        $filePath = str_replace('/',DIRECTORY_SEPARATOR, $this->dir_path . $view);


        if (!file_exists($filePath)) {
            throw new Exception("Template não encontrado: {$filePath}");
        }

        $this->template = $filePath;
        return $this;
    }

    /**
     * Define variáveis que serão usadas no template
     */
    public function set(string|array $key, ?string $value = null): self
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->variables[$k] = $v;
            }
        } else {
            $this->variables[$key] = $value ?? '';
        }
        return $this;
    }

    /**
     * Renderiza o template e substitui placeholders {variavel}
     */
    public function render(): string
    {
        if ($this->template === null) {
            throw new Exception("Nenhum template carregado.");
        }

        // Extrai as variáveis para uso dentro do template PHP
        extract($this->variables);

        
        // Captura o output do template
        ob_start();
        include $this->template;
        $output = ob_get_clean();

        // Substitui placeholders {variavel} no HTML final
        $output = preg_replace_callback('/\{@(\w+)\}/', function ($matches) {
            $key = $matches[1];
            return $this->variables[$key] ?? '';
        }, $output);

        return $output;
    }

    /**
     * Exibe diretamente
     */
    public function display(): void
    {
        echo $this->render();
    }

    private function dir_validation(string $dir) 
    {
        // validar barras no caminho.
        $str = $dir;
        $str = $str[0] == "/" ? substr_replace($str,'',0,1) : $str;
        $str = $str[strlen($str) - 1] == '/' ? $str : $str . '/';

        $this->dir_path = $this->baseDir . $str;
    }
}
