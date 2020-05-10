<?php

class Home extends Controller
{
    public function index($name = '')
    {
        $user = $this->model('User');
        $user->name = $name;

        $conn = new mysqli('localhost', 'interf', 'weakpassword', 'data');
        if ($conn->connect_error) {
            die('Could not connect: ' . $conn->connect_error);
        }

        $query = "SELECT name FROM locations";
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        $statement->execute();
        $result = $statement->get_result();
        $locations = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_row()){
                $locations[] = $row[0];
            }

        } else {
            $_SESSION['LOGGED_IN'] = false;
        }
        $conn->close();

        $this->view('home/index', ['locations' => $locations]);
    }

    public function register()
    {
        $conn = new mysqli('localhost', 'interf', 'weakpassword', 'data');
        if ($conn->connect_error) {
            die('Could not connect: ' . $conn->connect_error);
        }

        $query = "INSERT INTO users values(null, ?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        $statement->bind_param('ssssdd', $firstname, $lastname, $email, $password, $location, $admin);
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $location = 1;
        $admin = $_POST['accountType'];
        $statement->execute();
        $this->view('home/index', []);
    }

    public function login()
    {
        $conn = new mysqli('localhost', 'interf', 'weakpassword', 'data');
        if ($conn->connect_error) {
            die('Could not connect: ' . $conn->connect_error);
        }

        $query = "SELECT password FROM users where email = ?";
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        $statement->bind_param('s', $email);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_row();
            if (password_verify($password, $row[0])) {
                $_SESSION['LOGGED_IN'] = true;
                $this->view('home/user-page', []);
            }

        } else {
            $_SESSION['LOGGED_IN'] = false;
        }
        $conn->close();
    }


}