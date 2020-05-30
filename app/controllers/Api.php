<?php


class Api extends Controller
{


    public function insertdata()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            file_put_contents('../app/logs/error.log', $_POST);
            $conn = Database::instance()->getconnection();
            $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?, ?)';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('dsdddddd', $location, $date, $paper, $metal, $waste, $glass, $plastic, $mixed);
            $location = $this->getlocid($_POST['location']);
            $date = date('Y-m-d H:i:s');
            $paper = $_POST['paper'];
            $metal = $_POST['metal'];
            $plastic = $_POST['plastic'];
            $waste = $_POST['waste'];
            $glass = $_POST['glass'];
            $mixed = $_POST['mixedGarbage'];
            $statement->execute();
            http_response_code(200);
            exit;

        } else {
            http_response_code(405);
            require_once '../app/errors/405_error.php';
        }
    }

    private function bindparams($query, $params)
    {
        $conn = Database::instance()->getconnection();
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        if (!empty($params))
            call_user_func_array(array($statement, "bind_param"), $params);
        return $statement;

    }

    private function getlocid($location){
        $conn = Database::instance()->getconnection();
        $location = strtolower($location);
        $query = "select id from locations where lower(name) = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param('s', $location);
        $statement->execute();
        if (!$statement) {

            die('Error at statement' . var_dump($conn->error_list));
        }
        return $statement->get_result()->fetch_row()[0];
    }
    private function processdata()
    {
        $data = [];
        // $conn = Database::instance()->getconnection();
        $params = [];
        $id = -1;
        if (isset($_GET['location'])) {
            $id = $this->getlocid($_GET['location']);
        }
        $query = 'select name, address, report_date, paper, plastic, metal, glass, waste, mixed from materials m join locations l on m.location_id = l.id';
        if (isset($_GET['location']) && isset($_GET['date'])) {
            $query = $query . ' where ';
            $query = $query . 'report_date = ? ';
            $query = $query . 'and location_id = ?';
            $date = $_GET['date'];
            $params[] = 'sd';
            $params[] = &$date;
            $params[] = &$id;
        } elseif (isset($_GET['location'])) {
            $query = $query . ' where ';
            $query = $query . 'location_id = ?';
            $location = $_GET['location'];
            $params[] = 'd';
            $params[] = &$id;
        } elseif (isset($_GET['date'])) {
            $query = $query . ' where ';
            $query = $query . 'report_date = ?';
            $date = $_GET['date'];
            $params[] = 's';
            $params[] = &$date;
        }
        $statement = $this->bindparams($query, $params);

        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_row()) {
            $data[] = array('LocationName' => $row[0], 'Address' => $row[1], 'Date' => $row[2], 'paper' => $row[3], 'plastic' => $row[4], 'metal' => $row[5], 'glass' => $row[6], 'waste' => $row[7], 'mixed' => $row[8]);
        }

        return $data;

    }

    public function report()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = Database::instance()->getconnection();
            $query = 'insert into reports values(null, ?, ?, ?, ?)';
            $statement = $db->prepare($query);
            $statement->bind_param('ddss', $location, $type, $text, $date);
            $location = 1;
            $type = 1;
            $text = $_POST['text'];
            $date = date('Y-m-d H:i:s');
            $statement->execute();

        } else {
            http_response_code(405);
            require_once ERROR_PATH . '405_error.php';
        }
    }

    public function getdata($params = [])
    {
        switch ($params ?? 'json') {
            default:
                header('Content-Type: application/json');
                echo json_encode($this->processdata($_GET['date'] ?? ''));
                break;
            case 'csv':
                echo 'csv';
                $output = fopen("php://output", 'w') or die("Can't open php://output");
                header("Content-Type:application/csv");
                header("Content-Disposition:attachment;filename=data.csv");
                fputcsv($output, array('name', 'address', 'date', 'paper', 'plastic', 'metal', 'glass', 'waste'));
                $data = $this->processdata($_POST['date'] ?? '');
                foreach ($data as $dat) {
                    fputcsv($output, $dat);
                }

                break;
            case 'pdf':
                echo 'pdf';
                break;
        }
    }
}