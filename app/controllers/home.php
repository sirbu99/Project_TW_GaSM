<?php


class Home extends Controller
{
    private function getlocations()
    {
        $conn = Database::instance()->getconnection();
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
        return $locations;
    }

    public function loginpage($name = '')
    {
        $user = $this->model('User');
        $user->name = $name;
        if (!($_SESSION['LOGGED_IN'] ?? false)) {

            $locations = $this->getlocations();
            $this->view('home/index', ['locations' => $locations]);
        } else {
            $this->redirect('/home/userpage');
        }
    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = Database::instance()->getconnection();
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
            $this->redirect('/home');
            exit;
        }else{
            http_response_code(405);
            require_once ERROR_PATH . '405_error.php';
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = Database::instance()->getconnection();

            $query = "SELECT password, is_admin, id, location_id FROM users where email = ?";
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('s', $email);
            if(!isset($_POST['email']) || !isset($_POST['password'])){
                http_response_code(400);
                require_once ERROR_PATH . '400_error.php';
                exit;
            }
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
                    $_SESSION['ID'] = $row['id'];
                    $_SESSION['LOCATION_ID'] = $row['location_id'];
                    $this->redirect('/home/userpage');
                    exit;
                }

            }
        } else {
            http_response_code(405);
            require_once ERROR_PATH . '405_error.php';
            exit;
        }
    }

    public function userPage()
    {
        $locations = $this->getlocations();

        $this->view('home/userpage', ['locations' => $locations]);
    }

    public function info()
    {
        $this->view('home/info', []);
    }


}