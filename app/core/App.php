<?php

class App
{
    protected $controller = 'home';
    protected $method = 'page_404';
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
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $this->controller = 'home';
                $this->method = 'page_404';
            }
        } else {
            $this->method = 'loginpage';
        }


        $tempcont = $this->controller;
        $this->controller = new $this->controller;
        $this->params = $url ? array_values($url) : [];

        if (AuthMiddleware::run($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            http_response_code(403);
            if ($tempcont == 'home') {
                header("Location: " . BASE_URL . "/home/loginpage");
            } else {
                require_once ERROR_PATH . '403_error.php';
            }

            exit;
        }

    }

    public function parseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = strtok(ltrim($url, '/'), '?');

        return explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

    }
}