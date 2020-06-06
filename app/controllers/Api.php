<?php


class Api extends Controller
{


    public function insertdata()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            file_put_contents('../app/logs/error.log', $_POST);
            $conn = Database::instance()->getconnection();
            $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('dsddddddd', $location, $date, $type, $paper, $metal, $waste, $glass, $plastic, $mixed);
            $location = $this->getlocid($_POST['location']);
            $date = date('Y-m-d H:i:s');
            $paper = $_POST['paper'];
            $metal = $_POST['metal'];
            $plastic = $_POST['plastic'];
            $waste = $_POST['waste'];
            $glass = $_POST['glass'];
            $mixed = $_POST['mixedGarbage'];
            $type = $_POST['type'];
            $statement->execute();
            http_response_code(200);
            exit;

        } else {
            http_response_code(405);
            require_once '../app/errors/405_error.php';
        }
    }

    static function bindparams($query, $params)
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

    private function getlocid($location)
    {
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
            $query = 'insert into reports values(null, ?, ?, ?, ?, ?, ?)';
            $statement = $db->prepare($query);
            $statement->bind_param('ddssdd', $location, $type, $text, $date, $lat, $long);
            $location = $_SESSION['LOCATION_ID'];
            $type = $_POST['issue'];
            $text = $_POST['text'];

            $date = date('Y-m-d H:i:s');
            $lat = $_POST['latitude'];
            $long = $_POST['longitude'];
            $statement->execute();

        } else {
            http_response_code(405);
            require_once ERROR_PATH . '405_error.php';
        }
    }

    private function processrep(){
        $county = 1;
        $query = "select * from generated_reports";
        $conn = Database::instance()->getconnection();
        if(isset($_GET['county'])){
            $county = $_GET['county'];
            $query = $query . ' where county_id = ?';
        }
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        if(isset($_GET['county'])){
            $statement->bind_param('d', $_GET['county']);
        }
        $statement->execute();
        $result = $statement->get_result();
        $data = [];
        while($row = $result->fetch_row()){
            $data[] = array('county_id' => $row[1], 'date' => $row[2], 'added_paper' => $row[3], 'added_metal' => $row[4], 'added_glass' => $row[5], 'added_waste' => $row[6], 'added_plastic' => $row[7], 'added_mixed' => $row[8], 'recycled_paper' => $row[9], 'recycled_metal' => $row[10], 'recycled_glass' => $row[11], 'recycled_waste' => $row[12], 'recycled_plastic' => $row[13], 'processed_mixed' => $row[14], 'litter_complaints' => $row[15], 'collecting_complaints' => $row[16], 'net_materials' => $row[17]);
        }
        return $data;

    }

    public function getdata($params = [])
    {
        $method = 'processdata';
        if(isset($_GET['report']))
        switch ($_GET['report']){
            case 'monthly':
                $method = 'processrep';
                break;
            default:
                $method = 'processdata';

        }
        switch ($params ?? 'json') {
            default:
                header('Content-Type: application/json');
                echo json_encode(call_user_func(array($this, $method)));
                break;
            case 'csv':
                $output = fopen("php://output", 'w') or die("Can't open php://output");
                header("Content-Type:application/csv");
                header("Content-Disposition:attachment;filename=data.csv");
                $data = call_user_func(array($this, $method));
                fputcsv($output, array_keys($data[0]));
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