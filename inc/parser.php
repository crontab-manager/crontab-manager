<?php
namespace exporter\parser;
use exporter\regex;
use exporter\ssh;
use exporter\config;


class parser {

    private $matches_keys =                  array('match','commentinactive','m','h','dom','mon','dow','command');
    private $matches_keys_comment =          array('match','commentinactive','m','h','dom','mon','dow','command','comment');
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
//        print_r($this->arrayparsedcrontab);
    }

    /**
     * @param $splitdata
     * @return array
     */
    public function getParsedCrontab($splitdata)
    {
        $return = array();
        $group = 0;
        $x = 0;
        $comment = "";
        $groupcomment = "";

        foreach ($splitdata as $crontabline) {
            $commentinactive = "";
            //leere Zeile
            if ($crontabline == "") {
                $comment = "";
                $groupcomment = "";
                $group++;
                $x = 0;
                $return[$group] = array(
                    'groupcomment' => '',
                    'jobs' => array()
                );
            } else {
                $parsedline = $this->parseLine($crontabline);
                //kein Ergebnis
                if ($parsedline['state'] == 0) {
                    if ($crontabline[0] == '#') {
                        $groupcomment .= substr($crontabline, 1) . "\n";
                        if ($groupcomment == substr($crontabline, 1) . "\n") {
                            $return[$group]['groupcomment'] = substr($crontabline, 1) . "\n";
                        } else {
                            $return[$group]['groupcomment'] .= substr($crontabline, 1) . "\n";
                        }


                        //    $return[$group]['groupcomment'] .= substr($crontabline, 1) . "\n";
                    }
                } elseif ($parsedline['state'] == 1) {

//                    echo "=====================================\n";
//                    echo "LINE: " . $crontabline . "\n";
//                    echo "GROUP: " . $group . "\n";
//                    echo "GROUPCOMMENT: " . $groupcomment . "\n";
//                    echo "COMMENT: " . $comment . "\n";
//                    echo "x: " . $x . "\n";
//                    echo "jobart:" . $parsedline['job'] . "\n";
//                    echo "=====================================\n";

                    $keystomatch = $this->matches_keys;

                    switch ($parsedline['job']) {
                        case 'inactive command':
                            $keystomatch = $this->matches_keys;
                            $commentinactive = $parsedline['matches']['1'];
                            break;
                        case 'inactive command with comment':
                            $keystomatch = $this->matches_keys_comment;
                            $commentinactive = $parsedline['matches']['1'];
                            $comment = $parsedline['matches']['8'];
                            break;
                        case 'command with comment':
                            $keystomatch = $this->matches_keys_comment;
                            $comment = $parsedline['matches']['8'];
                            break;
                        case 'command':
                            $keystomatch = $this->matches_keys;
                            break;
                    }

//                    print_r($parsedline);
                    $return[$group]['jobs'][] = array(
                        'comment' => $comment,
                        'command' => $crontabline,
                        'commentinactive' => $commentinactive,
                        'matches' => array_combine($keystomatch, $parsedline['matches'])
                    );
                    $x++;
                }
            }
        }
        return $return;
    }


    /**
     * @param $line
     */
    public function parseLine($line)
    {
        $regex = '/^(' . regex::$regexcominactive . ')?\s*(' . regex::$regexmin . ')\s+(' . regex::$regexhrs . ')\s+(' . regex::$regexdom . ')\s+(' . regex::$regexmon . ')\s+(' . regex::$regexdow . ')\s+(.[^#]+)' . regex::$regexcomeol . '?#*$/';
        if (preg_match($regex, $line, $matches)) {
//            echo "=================\n";
//            echo $regex . "\n";
//            echo "=================\n";
//            print_r($matches);
            if (count($matches) == 9) {
                if ($matches['1'] != '') {
                    //echo "inactive with comment\n";
                    return array('state' => true, 'matches' => $matches, 'job' => "inactive command with comment");
                } else {
                    //echo "command with comment\n";
                    return array('state' => true, 'matches' => $matches, 'job' => "command with comment");
                }
            } else {
                if ($matches['1'] != '') {
                    //echo "inactive\n";
                    return array('state' => true, 'matches' => $matches, 'job' => "inactive command");
                } else {
                    //echo "command\n";
                    return array('state' => true, 'matches' => $matches, 'job' => "command");
                }

            }
        }

        return array('state' => false, 'job' => "empty");
    }



}