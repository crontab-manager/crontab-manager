<?php
namespace exporter\parser;
use exporter\regex;


class parser {

    private $ServerToTest = Array();
    private $x = 0;
    public $arrayparsedcrontab = Array();

    /**
     *
     * @return array
     */
    public function getIniSettings(){
        $filename = "config.ini";
        $array = parse_ini_file($filename);
        $this->ServerToTest = $array;
    }

    /**
     * @param $serveriptotest
     * @return resource
     */
    public function getsshConnection($serveriptotest){
        $connection = ssh2_connect($serveriptotest, 22);
        ssh2_auth_password($connection, 'root', 'test');
        return $connection;
        }

    /**
     * @param $connection
     * @param $commandtotest
     * @return string
     */
    public function getsshStreamData($connection, $commandtotest){
        $stream = ssh2_exec($connection, $commandtotest);
        stream_set_blocking($stream, true);
        $data = "";
        while ($buf = fread($stream, 4096)) {
            $data .= $buf;
        }
        fclose($stream);
        return $data;
    }

    public function getAllCrontabs()
    {
        $this->getIniSettings();
        foreach ($this->ServerToTest['serverip'] as $serveriptotest) {
             $this->getCrontabFromRemoteServer($serveriptotest);
        }
        print_r($this->arrayparsedcrontab);
    }

    /**
     *
     * @param $serveriptotest
     */
    public function getCrontabFromRemoteServer($serveriptotest){
            $connection = $this->getsshConnection($serveriptotest);
            $data = $this->getsshStreamData($connection,"tail /var/spool/cron/crontabs/root");
            $splitdata=explode("\n",$data);
            print_r ($splitdata);
            $this->getParsedCrontab($splitdata,$serveriptotest);
        // return $arrayparsedcrontab;
    }

    /**
     * @param $splitdata
     * @param $serveriptotest
     * @return bool
     */
    public function getParsedCrontab($splitdata,$serveriptotest){
        $comment = "";
        foreach ($splitdata as $crontabline){
            if ($crontabline=="") {
                $comment = "";
            }
            elseif (substr($crontabline,0,1) == '#') {
                $comment .= $crontabline."\n";
            }
            else {
                $parsedline = $this->parseLine($crontabline);
                if ($parsedline['state']== 1) {
                    $this->arrayparsedcrontab[$this->x]['serverip'] = $serveriptotest;
                    $this->arrayparsedcrontab[$this->x]['comment'] = $comment;
                    $this->arrayparsedcrontab[$this->x]['command'] = $crontabline."\n";
                    $this->x++;
                }
            }
        }
        return true;
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