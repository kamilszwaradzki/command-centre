<?php
namespace Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, string $controllerClass, string $action): void
    {
        $this->routes[] = [
            'method'   => strtoupper($method),
            'pattern'  => '#^' . str_replace('/', '\/', $path) . '$#',
            'class'    => $controllerClass,
            'action'   => $action
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // usuń pełne dopasowanie

                $ctrl = new $route['class']();
                if (!method_exists($ctrl, $route['action'])) {
                    $this->notFound();
                    return;
                }

                call_user_func_array([$ctrl, $route['action']], $matches);
                return;
            }
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        require __DIR__ . '/../../views/404.php';
        exit;
    }
}