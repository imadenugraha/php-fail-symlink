<?php
// src/Router.php
// Simple router using relative paths

class Router {
    private $routes = [];
    
    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }
    
    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }
    
    public function dispatch($uri, $method = 'GET') {
        // Remove query string
        $uri = strtok($uri, '?');
        
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            
            if (is_callable($handler)) {
                return $handler();
            }
            
            // Handle Controller@method format
            if (is_string($handler) && strpos($handler, '@') !== false) {
                list($controller, $method) = explode('@', $handler);
                
                // PROBLEMATIC: Relative path to load controller
                $controllerFile = '../src/controllers/' . $controller . '.php';
                
                if (!file_exists($controllerFile)) {
                    throw new Exception("Controller file not found: $controllerFile");
                }
                
                require_once $controllerFile;
                
                $controllerInstance = new $controller();
                return $controllerInstance->$method();
            }
        }
        
        http_response_code(404);
        echo "404 - Page not found: $uri";
    }
}
