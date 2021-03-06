<?php

namespace ihate\mvc;

use ihate\mvc\Application;
use ihate\mvc\middlewares\BaseMiddleware;

class Controller {

    protected array $middlewares = [];

    public string $layout = 'main';
    public string $action = '';

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
}

?>