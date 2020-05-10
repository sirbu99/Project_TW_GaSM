<?php

class App
{
    protected $controller = 'home';
    protected $method = 'loginpage';
    protected $params = [];

    public function __construct()
    {
        session_start();
        $url = $this->parseUrl();
        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->controller = new $this->controller;
        $this->params = $url ? array_values($url) : [];

        if ( AuthMiddleware::run($this->controller,  $this->method) ) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            header("Location: " . BASE_URL . "/home");
            exit;
        }

    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}