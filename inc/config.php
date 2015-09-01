<?php
namespace exporter\config;

use exceptionhandler;

class config implements \ArrayAccess {

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

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->Config);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset) {
        return $this->Config[$offset];
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value) {
        exceptionhandler::handler("not allowed for ".__CLASS__,$value);
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset) {
        exceptionhandler::handler("not allowed for ".__CLASS__,$offset);
}}