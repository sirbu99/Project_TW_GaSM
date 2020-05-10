<?php


class Controller
{
    protected $dbData = [];

    public function __construct()
    {
        $this->dbData = require(BASE_PATH . '../config/database.php');
    }

    public function model($model){
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []){
        require_once '../app/views/'. $view . '.php';
    }
}