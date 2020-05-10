<?php


class Home extends Controller
{
    public function loginpage($name = '')
    {
        $user = $this->model('User');
        $user->name = $name;
        if(!isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] == true) {
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
                while ($row = $result->fetch_row()) {
                    $locations[] = $row[0];
                }

            }
            $conn->close();

            $this->view('home/index', ['locations' => $locations]);
        }else{
            $this->redirect('/home/userpage');
        }
    }

    public function register()
    {
        $conn = new mysqli($this->dbData['host'], $this->dbData['user'], $this->dbData['pass'], $this->dbData['database']);
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
//        $this->view('home/index', []);
        $this->redirect('/home');
        exit;
    }

    public function login()
    {
        $conn = new mysqli($this->dbData['host'], $this->dbData['user'], $this->dbData['pass'], $this->dbData['database']);
        if ($conn->connect_error) {
            die('Could not connect: ' . $conn->connect_error);
        }

        $query = "SELECT password, is_admin FROM users where email = ?";
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
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['LOGGED_IN'] = true;
                $_SESSION['IS_ADMIN'] = $row['is_admin'];
//                $this->view('home/userpage', []);
               // header("Location: " . BASE_URL . "/home/userpage");
                $this->redirect('/home/userpage');
                exit;
            }

        }
        $conn->close();
    }

    public function userPage()
    {
        $this->view('home/userpage', []);
    }


}