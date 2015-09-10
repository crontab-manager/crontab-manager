<?php
namespace exporter\ssh;

class ssh {

    /**
     * @param $serveriptotest
     * @return resource
     */
    private static function getsshConnection($serveriptotest) {
        $connection = ssh2_connect($serveriptotest, 22);
        ssh2_auth_password($connection, 'root', 'test');
        return $connection;
    }

    /**
     * @param $connection
     * @param $commandtotest
     * @return string
     */
    private static function getsshStreamData($connection, $commandtotest) {
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
     * @param        $serveriptotest
     *
     * @param string $user
     *
     * @return array
     */
    public static function getCrontabFromRemoteServer($serveriptotest,$user) {
        $connection = self::getsshConnection($serveriptotest);
        $data       = self::getsshStreamData($connection, "crontab -l -u " . $user);
        return explode("\n", $data);
        //print_r($splitdata);
        //$this->getParsedCrontab($splitdata,$serveriptotest);
        // return $arrayparsedcrontab;
    }

}