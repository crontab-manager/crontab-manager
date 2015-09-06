<?php
namespace exporter\parser;
use exporter\regex;
use exporter\ssh;
use exporter\config;


class parser {

    private $matches_keys = array('match','m','h','dom','mon','dow','command');
    private $matches_keys_inactive = array('match','comment','m','h','dom','mon','dow','command');
    private $arrayparsedcrontab = Array();

    /**
     * @return array
     */
    public function getArrayparsedcrontab() {
        return $this->arrayparsedcrontab;
    }

    public function getAllCrontabs() {
        $ssh = new ssh\ssh();
        $config = new config\config();
        $server = $config->getServers();
        foreach ($server['serverip'] as $serveriptotest) {
             $ssh->getCrontabFromRemoteServer($serveriptotest,"root");
        }
        print_r($this->arrayparsedcrontab);
    }

    /**
     * @param $splitdata
     * @return array
     */
    public function getParsedCrontab($splitdata) {
        $return  = array();
        $group   = 0;
        $x = 0;
        $parsedline= "";
        $comment = "";
        $groupcomment = "";

        foreach ($splitdata as $crontabline) {
            //echo $crontabline."\n";
            //leere Zeile
            if ($crontabline == "") {
                $comment = "";
                $group++;
                $x = 0;
                $return[$group] = array(
                    'groupcomment' => '',
                    'jobs' => array()
                );
            } else {
                $parsedline = $this->parseLine($crontabline);
            }
            print_r($parsedline);
            //kein Ergebnis
            if ($parsedline['state'] == 0) {
                if ($crontabline[0] == '#') {
                    $return[$group]['groupcomment'] = substr($crontabline, 1) . "\n";
                }
            } elseif ($parsedline['state'] == 1) {
                echo "=====================================\n";
                echo "LINE: " . $crontabline . "\n";
                echo "GROUP: " . $group . "\n";
                echo "x: " . $x . "\n";
                echo "=====================================\n";
                if ($parsedline['job'] == 'inactive command') {
                    $keystomatch = $this->matches_keys_inactive;
                }
                else {
                    $keystomatch = $this->matches_keys;
                }

                $return[$group]['jobs'][] = array(
                    'comment' => $comment,
                    'command' => $crontabline,
                    'matches' => array_combine($keystomatch, $parsedline['matches'])
                );
                $x++;
            }
        }

    }

    /**
     * @param $line
     *
     * @return bool
     */
    public function parseLine($line) {
        $regex = '/^(' . regex::$regexmin . ')\s+(' . regex::$regexhrs. ')\s+(' . regex::$regexdom . ')\s+(' . regex::$regexmon . ')\s+(' . regex::$regexdow . ')\s+(.+)$/';
        if (preg_match($regex,$line,$matches)) {
            return array('state' => true, 'matches' => $matches, 'job' => "command", 'comment' => "");
        }
        else {
            $comment = "";
            $regex = '/^([#]+[^#]*#+)\s+(' . regex::$regexmin . ')\s+(' . regex::$regexhrs. ')\s+(' . regex::$regexdom . ')\s+(' . regex::$regexmon . ')\s+(' . regex::$regexdow . ')\s+(.+)$/';

            if (preg_match($regex,$line,$matches)) {
                return array('state' => true, 'matches' => $matches, 'job' => "inactive command", 'comment' => $comment);
            }
        }
        return array('state' => false,'job' => "empty");
    }


}