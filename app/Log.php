<?php

class Log{
    /**
     * @param $str
     * Puts str to log file
     */
    public static function addLog($str)
    {
        $str = "[" . date('H:i:s') . "]: " . $str . "\n";
        file_put_contents(Config::getFileLog(), $str, FILE_APPEND);
    }

    /**
     * Clears log file
     */
    public static function clearLog(){
        unlink(Config::getFileLog());
    }

    /**
     * @param array $last
     * Saves last posts' ids to .json file
     */
    public static function saveLast($last)
    {
        file_put_contents(Config::getFileLast(), json_encode($last));
    }
}