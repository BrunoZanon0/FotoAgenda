<?php

class Router {
    protected $routes = [];
    public $base_url;

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        $basePath       = 'servicos/barbearia';

        $this->base_url = $basePath;

        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
            $uri = trim($uri, '/');
        }

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            $this->callAction($action);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            header("location: http://localhost:9090/servicos/barbearia/notfound.php");
            die;
        }
    }

    protected function callAction($action) {
        list($controller, $method) = explode('@', $action);

        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../app/controller/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            header("location: notfound.php");
            die;
        }

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
                echo "404 Method Not Found";
                die;
            }
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            echo "404 Controller Not Found";
            die;
        }
    }
}
