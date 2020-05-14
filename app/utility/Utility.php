<?php


class Utility
{
    static public function report_routine()
    {
        $lastRunLog = '../app/logs/lastrun.log';
        if (file_exists($lastRunLog)) {
            $lastRun = file_get_contents($lastRunLog);
            if (time() - $lastRun >= 86400) {
                //its been more than a day so run our external file
                $cron = self::report();

                //update lastrun.log with current time
                file_put_contents($lastRunLog, time());
            }
        }
    }
    static private function report(){
        //
        $db = Database::instance()->getconnection();
        
    }
}