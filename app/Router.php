<?php
class Router {
    private $routes = [];

    // Add route with dynamic parameters support
    public function addRoute($uri, $controller, $method, $middleware = null) {
        $this->routes[$uri] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
    }

    // Dispatch method to handle requests
    public function dispatch($uri = '/') {
        $uri = $uri;

        // Match route or return 404
        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];

            // Handle middleware
            if ($route['middleware']) {
                $middlewareClass = $route['middleware'];
                if (class_exists($middlewareClass)) {
                    (new $middlewareClass())->handle();
                } else {
                    header("HTTP/1.0 500 Internal Server Error");
                    require __DIR__ . '/Views/Errors/500.php';
                    exit();
                }
            }

            // Instantiate controller and call method
            $controllerClass = $route['controller'];
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $route['method'])) {
                    call_user_func([$controller, $route['method']]);
                } else {
                    echo "Method {$route['method']} not found";
                    header("HTTP/1.0 404 Not Found");
                    require __DIR__ . '/Views/Errors/404.php';
                    exit();
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                require __DIR__ . '/Views/Errors/404.php';
                exit();
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            require __DIR__ . '/Views/Errors/404.php';
        }
    }
}
?>
