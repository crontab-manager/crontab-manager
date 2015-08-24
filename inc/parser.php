<?php
namespace exporter\parser;
use exporter\regex;


class parser {

    private $matches_keys = array('match','m','h','dom','mon','dow','command');

    private $arrayparsedcrontab = Array();

    /**
     * @return array
     */
    public function getArrayparsedcrontab() {
        return $this->arrayparsedcrontab;
    }

    public function getAllCrontabs() {
        $this->getIniSettings();
        foreach ($this->ServerToTest['serverip'] as $serveriptotest) {
             $this->getCrontabFromRemoteServer($serveriptotest);
        }
        print_r($this->arrayparsedcrontab);
    }

    /**
     * @param $splitdata
     * @return array
     */
    public function getParsedCrontab($splitdata) {
        $comment = "";
        $return  = array();
        $group   = 0;
        foreach ($splitdata as $crontabline){
            if ($crontabline=="") {
                $comment = "";
                $group++;
            }
            elseif ($crontabline[0] == '#') {
                $comment .= substr($crontabline,1)."\n";
            }
            else {
                $parsedline = $this->parseLine($crontabline);
                if ($parsedline['state']== 1) {
                    /*
                    echo "=====================================\n";
                    echo "LINE: ".$crontabline."\n";
                    echo "GROUP: ".$group."\n";
                    echo "=====================================\n";
                    */
                    $return[$group][]=array(
                      'comment' => $comment,
                      'command' => $crontabline,
                      'matches' => array_combine($this->matches_keys,$parsedline['matches'])
                    );

                } else {
                    echo "### Ignore Line: ".$crontabline."\n";
                }
            }
        }
        return $return;
    }

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



}