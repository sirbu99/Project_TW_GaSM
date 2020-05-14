<?php


class Api extends Controller
{


    public function insertdata()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = Database::instance()->getconnection();
            $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?, ?)';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('dsdddddd', $location, $date, $paper, $metal, $waste, $glass, $plastic, $mixed);
            $location = 1;
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

    private function processdata($date = '')
    {
        $data = [];
        $conn = Database::instance()->getconnection();
        if ($date == '') {
            $query = 'select name, address, report_date, paper, plastic, metal, glass, waste, mixed from materials m join locations l on m.location_id = l.id';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
        } else {
            $query = 'select name, address, report_date, paper, plastic, metal, glass, waste, mixed from materials m join locations l on m.location_id = l.id where report_date = ?';
            $statement = $conn->prepare($query);
            if (!$statement) {
                die('Error at statement' . var_dump($conn->error_list));
            }
            $statement->bind_param('s', $date);
        }
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_row()) {
            $data[] = array('LocationName' => $row[0], 'Address' => $row[1], 'Date' => $row[2], 'paper' => $row[3], 'plastic' => $row[4], 'metal' => $row[5], 'glass' => $row[6], 'waste' => $row[7], 'mixed' => $row[8]);
        }

        return $data;

    }

    public function report(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $db = Database::instance()->getconnection();
            $query = 'insert into reports values(null, ?, ?, ?, ?)';
            $statement = $db->prepare($query);
            $statement->bind_param('ddss', $location, $type, $text, $date);
            $location = 1;
            $type = 1;
            $text = $_POST['text'];
            $date = date('Y-m-d H:i:s');
            $statement->execute();

        }else{
            http_response_code(405);
            require_once  ERROR_PATH . '405_error.php';
        }
    }

    public function getdata($params = [])
    {
            switch ($params ?? 'json') {
                default:
                    header('Content-Type: application/json');
                    echo json_encode($this->processdata($_POST['date'] ?? ''));
                    break;
                case 'csv':
                    echo 'csv';
                    $output = fopen("php://output",'w') or die("Can't open php://output");
                    header("Content-Type:application/csv");
                    header("Content-Disposition:attachment;filename=data.csv");
                    fputcsv($output, array('name','address','date', 'paper', 'plastic', 'metal', 'glass', 'waste'));
                    $data = $this->processdata($_POST['date'] ?? '');
                    foreach($data as $dat) {
                        fputcsv($output, $dat);
                    }

                    break;
                case 'pdf':
                    echo 'pdf';
                    break;
            }
        }
}