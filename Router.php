<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router {

    protected array $routes = [];
    protected Request $request;
    protected Response $response;


    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {
        $path = $this->request->path();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            throw new NotFoundException();
        }
        
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];


            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

            $callback[0] = $controller;

        }



        return call_user_func($callback, $this->request, $this->response);
    }
}

?>