<?php
namespace exporter\config;

class config {

    private $Config = array();

    /**
     * @return array
     */
    public function getConfig() {
        return $this->Config;
    }

    /**
     * @return array
     */
    public function getServers() {
        return $this->Servers;
    }
    private $Servers = array();

    public function __construct() {
        $this->Config  = $this->getConfigFile('config/config.ini');
        $this->Servers = $this->getConfigFile('config/server.ini');
    }

    private function getConfigFile($filename) {
        if (file_exists($filename)) {
            return parse_ini_file($filename, true);
        } else {
            throw new \Exception('missing file: '.$filename);
        }
    }

}