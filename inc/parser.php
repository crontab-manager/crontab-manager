<?php
namespace exporter\parser;
use exporter\regex;


class parser {

    public $ServerToTest = Array();

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

    /**
     *
     */
    public function getCrontabFromRemoteServer(){
        $this->getIniSettings();
        foreach ($this->ServerToTest['serverip'] as $serveriptotest) {
            $connection = $this->getsshConnection($serveriptotest);
            $data = $this->getsshStreamData($connection,"tail /var/spool/cron/crontabs/root");
            $splitdata=explode("\n",$data);
            $x = 0;
            $comment = "";
            $arraydb = array();

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
                       $arraydb[$x]['comment'] = $comment;
                       $arraydb[$x]['command'] = $crontabline."\n";
                       $x++;
                   }
               }
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
            return array('state' => true, 'matches' => $matches);
        }
        return array('state' => false);
    }



}