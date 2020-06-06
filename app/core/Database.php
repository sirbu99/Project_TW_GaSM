<?php


final class Database
{
    private $conn;
    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Database();
        }
        return $inst;
    }
    private function __construct()
    {
        $this->conn = new mysqli('localhost', 'interf', 'weakpassword', 'data');
        if ($this->conn->connect_error) {
            die('Could not connect: ' . $this->conn->connect_error);
        }
    }
    public function getconnection(){
        return $this->conn;
    }
}