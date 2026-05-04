<?php
// Gère les routes URL → contrôleur

class Router {
    private array $routes = [];
    private string $method;
    private string $uri;

    public function __construct(string $method, string $uri)
    {
        $this->method = strtoupper($method);
        $this->uri = rtrim($uri, '/') === '' ? '/' : rtrim($uri, '/');
    }

    public function get(string $path, string $handler): void
    {
        $this->register('GET', $path, $handler);
    }

    private function register(string $method, string $path, string $handler): void
    {
        $path = rtrim($path, '/') === '' ? '/' : rtrim($path, '/');
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $this->method && $route['path'] === $this->uri) {
                $this->callAction($route['handler']);
                return;
            }
        }

        $this->notFound();
    }

    private function callAction(string $handler): void
    {
        [$controllerName, $action] = explode('@', $handler);

        if (!class_exists($controllerName)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            $this->notFound();
            return;
        }

        $controller->{$action}();
    }

    private function notFound(): void
    {
        header('HTTP/1.1 404 Not Found');
        echo '<h1>404 - Page non trouvée</h1>';
        echo '<p>La page demandée est introuvable.</p>';
    }
}
