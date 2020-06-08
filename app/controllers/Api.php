<?php


class Api extends Controller
{


    public function insertdata()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = Database::instance()->getconnection();
            $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $statement = $conn->prepare($query);
            if (!$statement) {
                file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
                http_response_code(500);
                die;
            }
            $statement->bind_param('dsddddddd', $location, $date, $type, $paper, $metal, $waste, $glass, $plastic, $mixed);
            $location = $this->getlocid($_POST['location']);
            $date = date('Y-m-d H:i:s');
            $paper = $_POST['paper'] ?? 0;
            $metal = $_POST['metal'] ?? 0;
            $plastic = $_POST['plastic'] ?? 0;
            $waste = $_POST['waste'] ?? 0;
            $glass = $_POST['glass'] ?? 0;
            $mixed = $_POST['mixedGarbage'] ?? 0;
            $type = $_POST['type'] ?? 1;
            $statement->execute();
            http_response_code(200);
            exit;

        } else {
            http_response_code(405);
            require_once '../app/errors/405_error.php';
        }
    }

    public function insertevent()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(405);
            require_once '../app/errors/405_error.php';
            exit;
        }
        file_put_contents('../app/logs/error.log', $_POST);
        $conn = Database::instance()->getconnection();
        $query = 'insert into event (titlu,data,id_autor,detalii, tags, descriere) values (?, ?, ?, ?, ?, ?)';
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        $statement->bind_param('ssdsss', $title, $date, $author_id, $details, $tags, $description);
        $date = $_POST["date"]; //validare si corectare format data
        $title = $_POST["title"];
        $author_id = intval($_SESSION["ID"] ?? 0);
        $details = $_POST["details"];
        $tags = $_POST["tags"];
        $description = $_POST["description"];

        $statement->execute();
        http_response_code(200);

    }

    public function insertcomment()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(405);
            require_once '../app/errors/405_error.php';
            exit;
        }

        file_put_contents('../app/logs/error.log', $_POST);
        $conn = Database::instance()->getconnection();
        $query = 'insert into comentarii (text,id_event,data,user_id) values (?, ?, ?, ?)';
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        $statement->bind_param('sdsd', $description, $idEvent, $data, $user_id);
        $description = $_POST["description"];
        $data = date("Y-m-d");
        $idEvent = intval($_POST["id"]);
        $user_id = $_SESSION["ID"];
        $statement->execute();
        http_response_code(200);

    }

    static function bindparams($query, $params)
    {
        $conn = Database::instance()->getconnection();
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
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
        if (!$statement) {
            file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        $statement->bind_param('s', $location);
        $statement->execute();
        if (!$statement) {

            die('Error at statement' . var_dump($conn->error_list));
        }
        return $statement->get_result()->fetch_row()[0];
    }

    private function processdata()
    {
        $conn = Database::instance()->getconnection();
        $data = [];
        // $conn = Database::instance()->getconnection();
        $params = [];
        $id = -1;
        if (isset($_GET['location'])) {
            $id = $this->getlocid($_GET['location']);
        }
        $def = '';
        $query = 'select name, address, report_date, paper, plastic, metal, glass, waste, mixed from materials m join locations l on m.location_id = l.id';
        if (isset($_GET['location']) && isset($_GET['date'])) {
            $query = $query . ' where ';
            $query = $query . 'report_date = ? ';
            $query = $query . 'and location_id = ?';
            $date = $_GET['date'];
            $def = 'sd';
            $params[] = $date;
            $params[] = $id;
        } elseif (isset($_GET['location'])) {
            $query = $query . ' where ';
            $query = $query . 'location_id = ?';
            $location = $_GET['location'];
            $def = 'd';
            $params[] = $id;
        } elseif (isset($_GET['date'])) {
            $query = $query . ' where ';
            $query = $query . 'report_date = ?';
            $date = $_GET['date'];
            $def = 's';
            $params[] = $date;
        }
        $query = $query . ' order by m.id desc';
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        if ($params)
            $statement->bind_param($def, ...$params);
        // $statement = $this->bindparams($query, $params);

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
            if (!$statement) {
                file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
                http_response_code(500);
                die;
            }
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

    private function processrep()
    {
        $county = 1;
        $query = "select * from generated_reports";
        $conn = Database::instance()->getconnection();
        if (isset($_GET['county'])) {
            $county = $_GET['county'];
            $query = $query . ' where county_id = ?';
        }
        $query = $query . ' order by id desc';
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        if (isset($_GET['county'])) {
            $statement->bind_param('d', $_GET['county']);
        }
        $statement->execute();
        $result = $statement->get_result();
        $data = [];
        while ($row = $result->fetch_row()) {
            $data[] = array('county_id' => $row[1], 'date' => $row[2], 'added_paper' => $row[3], 'added_metal' => $row[4], 'added_glass' => $row[5], 'added_waste' => $row[6], 'added_plastic' => $row[7], 'added_mixed' => $row[8], 'recycled_paper' => $row[9], 'recycled_metal' => $row[10], 'recycled_glass' => $row[11], 'recycled_waste' => $row[12], 'recycled_plastic' => $row[13], 'processed_mixed' => $row[14], 'litter_complaints' => $row[15], 'collecting_complaints' => $row[16], 'net_materials' => $row[17]);
        }
        return $data;

    }

    public function getdata($params = [])
    {
        $method = 'processdata';
        if (isset($_GET['report']))
            switch ($_GET['report']) {
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

    private function isInside($circle_x, $circle_y, $rad, $x, $y)
    {

        if (($x - $circle_x) * ($x - $circle_x) +
            ($y - $circle_y) * ($y - $circle_y) <=
            $rad * $rad)
            return true;
        else
            return false;
    }

    public function getlocations()
    {
        $conn = Database::instance()->getconnection();
        $query = "select name, county_id, lat, lng from locations";
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log','Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        $statement->execute();
        $result = $statement->get_result();
        $locs = [];
        while ($row = $result->fetch_row()) {
            $query = "select lat, lng, type from reports";
            $statement2 = $conn->prepare($query);
            $statement2->execute();
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $repres = $statement2->get_result();
            $count1 = 0;
            $count2 = 0;
            while ($rrow = $repres->fetch_row()) {
                if ($this->isInside($row[2], $row[3], 0.007, $rrow[0], $rrow[1])) {
                    if ($rrow[2] == 1) {
                        $count1++;
                    } else {
                        $count2++;
                    }
                }
            }
            $locs[] = ['name' => $row[0], 'county_id' => $row[1], 'complaints1' => $count1, 'complaints2' => $count2, 'latitude' => $row[2], 'longitude' => $row[3]];
        }

        header('Content-Type: application/json');
        echo json_encode($locs);
    }

    public function getEventInfo()
    {
        if (!isset($_GET['id'])) {
            return [];
        }
        $query = "select * from event where id = ?";
        $conn = Database::instance()->getconnection();
        $id_event = $_GET['id'];
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log','Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        if (isset($_GET['id'])) {
            $statement->bind_param('d', $id_event);
        }
        $statement->execute();
        $result = $statement->get_result();
        header("Content-Type:application/json");
        $event = $result->fetch_assoc();
        $event['comments'] = $this->getComments($id_event);
        echo json_encode($event);
        exit;
    }

    public function getComments($eventId)
    {
        $query = "select comentarii.*, users.first_name, users.last_name from comentarii left join users on comentarii.user_id=users.id where id_event = ? ";
        $conn = Database::instance()->getconnection();
        $statement = $conn->prepare($query);
        if (!$statement) {
            file_put_contents('../app/logs/error.log','Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
            http_response_code(500);
            die;
        }
        $statement->bind_param('d', $eventId);

        $statement->execute();
        $result = $statement->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function deleteEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $query = "delete from event where id = ?";
            $conn = Database::instance()->getconnection();
            $statement = $conn->prepare($query);
            if (!$statement) {
                file_put_contents('../app/logs/error.log','Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
                http_response_code(500);
                die;
            }
            $statement->bind_param('d', $eventId);
            $eventId = $_POST["id"];

            $statement->execute();
        } else {
            http_response_code(405);
            require_once ERROR_PATH . '405_error.php';
        }

    }
}