<?php


class Api
{
    public function insertdata(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo 'here';
            $conn = Database::instance()->getconnection();
            $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?)';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('dsddddd', $location, $date, $paper, $metal, $waste, $glass, $plastic);
            $location = 1;
            $date = date("D M d, Y G:i");
            $paper = $_POST['paper'];
            $metal = $_POST['metal'];
            $plastic = $_POST['plastic'];
            $waste = $_POST['mixedGarbage'];
            $glass = $_POST['glass'];
            $statement->execute();
            http_response_code(200);
            echo json_encode(array("message" => "Data has been added"));

        }
        else
        {
            echo 'here2';
            http_response_code(405);
            require_once '../app/errors/405_error.php';
        }
    }
}