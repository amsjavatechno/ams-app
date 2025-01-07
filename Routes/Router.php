<?php

namespace AmsApp\Routes;

class Router
{
    private $routes = [];
    private $middleware = [];

    public function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
        ];
    }

    public function addMiddleware($callback)
    {
        $this->middleware[] = $callback;
    }

    private function handleMiddleware($requestMethod, $requestPath)
    {
        foreach ($this->middleware as $middleware) {
            call_user_func($middleware, $requestMethod, $requestPath);
        }
    }

    public function match($requestMethod, $requestPath)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $routePath = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['path']);
            if (preg_match('#^' . $routePath . '$#', $requestPath, $matches)) {
                array_shift($matches); // Remove the full match
                return [
                    'callback' => $route['callback'],
                    'params' => $matches,
                ];
            }
        }

        return null;
    }

    public function dispatch($requestMethod, $requestPath)
    {
        $this->handleMiddleware($requestMethod, $requestPath);

        $route = $this->match($requestMethod, $requestPath);

        if ($route) {
            call_user_func_array($route['callback'], $route['params']);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

?>
