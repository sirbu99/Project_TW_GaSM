<?php


class Utility
{
    static public function report_routine()
    {
        $lastRunLog = '../app/logs/lastrun.log';
        if (file_exists($lastRunLog)) {
            $lastRun = file_get_contents($lastRunLog);
            if (time() - $lastRun >= 2592000) {
                $cron = self::report();
                file_put_contents($lastRunLog, time());
            }
        }
    }

    static private function report()
    {
        $conn = Database::instance()->getconnection();
        // DATE_FORMAT(`date`,'%M %Y')
        $query = 'SELECT id, name, lat1, lng1, lat2, lng2 from counties';
        $statement = $conn->prepare($query);
        if (!$statement) {
            die('Error at statement' . var_dump($conn->error_list));
        }
        $statement->execute();
        $result = $statement->get_result();
        $counties = [];
        while ($row = $result->fetch_row()) {
            $counties += [$row[0] => array($row[2], $row[3], $row[4], $row[5])];
        }
        $query = "select location_id, type, lat, lng from reports where DATE_FORMAT(report_date , '%M, %Y') = DATE_FORMAT(CURDATE()  - INTERVAL 1 MONTH, '%M, %Y')";
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $comp1 = [];
        $comp2 = [];
        $res = '';
        while ($row = $result->fetch_row()) {
            foreach ($counties as $county => $value) {
                if ($value[0] >= $row[2] and $value[1] >= $row[3] and $value[2] <= $row[2] and $value[3] <= $row[3]) {
                    if ($row[1] == 1) {
                        if (!isset($comp1[$county])) {
                            $comp1 += [$county => 1];
                        } else {
                            $comp1[$county] += 1;
                        }
                    } else {
                        if (!isset($comp2[$county])) {
                            $comp2 += [$county => 1];
                        } else {
                            $comp2[$county] += 1;
                        }
                    }
                    break;
                }
            }
        }
        //get materials data
        $query = "select type, paper, metal, glass, waste, plastic, mixed, county_id from materials join locations on materials.location_id = locations.id join counties c on locations.county_id = c.id where DATE_FORMAT(report_date , '%M, %Y') = DATE_FORMAT(CURDATE() - INTERVAL 1 Month , '%M, %Y')";
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $collected = [0, 0, 0, 0, 0, 0];
        $recycled = [0, 0, 0, 0, 0, 0];
        while ($row = $result->fetch_row()) {
            if ($row[0] == 1) {
                for($i = 0; $i < 6; $i++){
                    $collected[$i] += $row[$i+1];
                }
            } else {
                for($i = 0; $i < 6; $i++){
                    $recycled[$i] += $row[$i+1];
                }
            }
        }
        $total_materials = 0;
        foreach ($collected as $mats) {
            $total_materials += $mats;
        }
        foreach ($recycled as $mats) {
            $total_materials -= $mats;
        }
        $county = 1;
        $query = "insert into generated_reports values(null, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [1];
        $params = array_merge($params, array_merge($collected, $recycled));
        $params[] = $comp1[$county];
        $params[] = $comp2[$county];
        $params[] = $total_materials;
        $statement = $conn->prepare($query);
        $statement->bind_param('dddddddddddddddd', ...$params);
        $statement->execute();
    }
}