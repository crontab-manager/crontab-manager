<?php
namespace exporter\parser;
use exporter\regex;

class parser {

    /**
     * @param $line
     *
     * @return bool
     */
    public function parseLine($line) {
        $regex = '/^(' . regex::$regexmin . ')\s+(' . regex::$regexhrs. ')\s+(' . regex::$regexdom . ')\s+(' . regex::$regexmon . ')\s+(' . regex::$regexdow . ')\s+(.+)$/';
        if (preg_match($regex,$line,$matches)) {
            return array('state' => true, 'matches' => $matches);
        }
        return array('state' => false);
    }

    /**
     *
     */
    public function getCrontabFromRemoteServer(){
    }

}