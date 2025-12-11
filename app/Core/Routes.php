<?php

namespace app\Core;

use app\Factory\Request;
use Exception;

class Routes
{
    private $dir;
    private $routes = [];

    public function __construct() 
    {   
        $this->dir = str_replace('Core', 'Modules', __DIR__);
        $this->list_routes($this->get_modules($this->dir));  
    }

    /* ======================================================
       MÉTODO PRINCIPAL
       ====================================================== */

    protected function run()
    {   
        foreach ($this->routes as $module => $groups) {
            $this->process_module($module, $groups);
        }
    }

    /* ======================================================
       PROCESSAMENTO DE MÓDULOS E ROTAS
       ====================================================== */

    /**
     * Processa cada módulo individualmente
     */
    private function process_module(string $module, array $groups): void
    {
        foreach ($groups as $group) {
            $this->validate_group($module, $group);
            $this->process_group($group);
        }
    }

    /**
     * Valida a estrutura do grupo de rotas
     */
    private function validate_group(string $module, array $group): void
    {
        $static = strtolower(trim($group['static'] ?? ''));

        try {
            if (!$static) {
                throw new Exception("⚠️ A rota do módulo [$module] não está seguindo o formato correto!");
            }
        } catch (Exception $e) {
            echo '<pre>';
            echo $e->getMessage();
            echo "\n";
            print_r($group);
            echo '</pre>';
        }
    }

    /**
     * Processa as rotas dentro de um grupo
     */
    private function process_group(array $group): void
    {
        $static = strtolower(trim($group['static'] ?? ''));

        if (!isset($group['routes']) || !is_array($group['routes'])) return;

        foreach ($group['routes'] as $routeData) {
            $this->register_route($static, $routeData);
        }
    }

    /**
     * Registra uma rota individual (GET, POST, PUT, DELETE)
     */
    private function register_route(string $static, array $routeData): void
    {
        $path = $routeData['route'] === '/' ? '' : $routeData['route'];
        $route = ($static ? "/$static" : '') . str_replace(['{', '}'], ['$',''], $path);

        $http = $routeData['http'] ?? [];
        $controller = $routeData['controller'] ?? null;
        $method = $routeData['method'] ?? null;
        $middlewares = $routeData['middlewares'] ?? [];
        $active = $routeData['active'] ?? false;

        if (!$active || !$controller || !$method) return;

        foreach ($http as $verb) {
            $this->map_http_method($verb, $route, $controller, $method, $middlewares);
        }
    }

    /**
     * Faz o mapeamento do verbo HTTP para o método correspondente
     */
    private function map_http_method(string $verb, string $route, object $controller, string $method, array $middlewares): void
    {
        switch (strtoupper($verb)) {
            case 'GET':
                $this->set_route_get($route, $controller, $method, $middlewares);
                break;

            case 'POST':
                $this->set_route_post($route, $controller, $method, $middlewares);
                break;

            case 'PUT':
                $this->set_route_put($route, $controller, $method, $middlewares);
                break;

            case 'DELETE':
                $this->set_route_delete($route, $controller, $method, $middlewares);
                break;

            default:
                // Ignora métodos HTTP desconhecidos
                break;
        }
    }

    /* ======================================================
       MÉTODOS HTTP
       ====================================================== */

    private function set_route_get(string $route, object $controller, string $method, array $middlewares)
    {
        get($route, function () use ($controller, $method, $middlewares) {
            $controllerCallable = fn($req) => $controller->$method($req);
            $app = Pipeline::pip($middlewares, $controllerCallable);
            $req = new Request();
            $app($req);
        });
    }

    private function set_route_post(string $route, object $controller, string $method, array $middlewares)
    {
        post($route, function () use ($controller, $method, $middlewares) {
            $controllerCallable = fn($req) => $controller->$method($req);
            $app = Pipeline::pip($middlewares, $controllerCallable);
            $req = new Request();
            $app($req);
        });
    }

    private function set_route_put(string $route, object $controller, string $method, array $middlewares)
    {
        put($route, function () use ($controller, $method, $middlewares) {
            $controllerCallable = fn($req) => $controller->$method($req);
            $app = Pipeline::pip($middlewares, $controllerCallable);
            $req = new Request();
            $app($req);
        });
    }

    private function set_route_delete(string $route, object $controller, string $method, array $middlewares)
    {
        delete($route, function () use ($controller, $method, $middlewares) {
            $controllerCallable = fn($req) => $controller->$method($req);
            $app = Pipeline::pip($middlewares, $controllerCallable);
            $req = new Request();
            $app($req);
        });
    }

    /* ======================================================
       SISTEMA DE MÓDULOS
       ====================================================== */

    private function get_modules(string $path): array
    {
        $dirs = [];

        foreach (scandir($path) as $item) {
            if ($item === '.' || $item === '..' || !is_dir($path . DIRECTORY_SEPARATOR . $item)) continue;
            $dirs[] = $item;
        }

        return $dirs;
    }

    private function list_routes(array $modules): void
    {
        foreach ($modules as $module) {
            $routesPath = $this->dir . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'routes.php';

            if (file_exists($routesPath)) {
                $controllerClass = require $routesPath;
                $this->routes[$module] = $controllerClass;
            } else {
                echo "Arquivo routes.php não encontrado no módulo: $module\n";
            }
        }
    }
}
