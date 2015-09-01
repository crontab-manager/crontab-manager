<?php
namespace exporter\db;

use exporter\utils\utils;
use Pimple\Container;

class db implements db_interface {

    /**
     * @var \mysqli
     */
    private $link;
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function connect() {
        $this->link = new \mysqli(
            $this->container['config']['db']['host'],
            $this->container['config']['db']['user'],
            $this->container['config']['db']['pwd'],
            $this->container['config']['db']['db'],
            $this->container['config']['db']['port']
        );
        if ($this->link->connect_errno) {
            return array(
                    'state' => false,
                    'errno' => $this->link->connect_errno,
                    'error' => $this->link->connect_error
            );
        } else {
            $this->link->set_charset($this->container['config']['db']['charset']);
        }
        return array(
            'state'  => true,
            'server' => array(
                'server_info'    => $this->link->server_info,
                'server_version' => $this->link->server_version,
                'stat'           => $this->link->stat(),
                'host_info'      => $this->link->host_info
            )
        );
    }

    public function query($sql,array $params = array()) {
        $state           = false;
        $error           = null;
        $result          = array();
        $affected_rows   = 0;
        $numrows         = 0;
        $paramsWithTypes = array();

        $stmt = $this->link->prepare($sql);
        if (!$stmt) {
            return array(
                'state'         => $state,
                'numrows'       => $numrows,
                'result'        => $result,
                'affected_rows' => $affected_rows,
                'error'         => $this->link->error,
                'sql'           => $sql,
                'params'        => $params
            );
        }

        if ($params) {
            foreach ($params as $value) {
                $paramType               = utils::getParamType($value);
                $paramsWithTypes[$value] = $paramType;
            }
            if(count($paramsWithTypes)) {
                $bind_names[] = implode('',array_values($paramsWithTypes));
                $i = 0;
                foreach ($paramsWithTypes as $param => $type) {
                    $bind_name = 'bind' . $i;
                    $$bind_name = $param;
                    $bind_names[] = &$$bind_name;
                    $i++;
                }
                print_r($bind_names);
                call_user_func_array(array($stmt,'bind_param'),$bind_names);
            }
        }
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {

            $state         = true;
            $numrows       = 0;
            $affected_rows = ($stmt->affected_rows>0) ? $stmt->affected_rows : 0;
            $meta          = $stmt->result_metadata();
            $fields        = array();

            if ($meta) {
                while ($field = $meta->fetch_field()) {
                    $var          = $field->name;
                    $$var         = null;
                    $fields[$var] = &$$var;
                }

                call_user_func_array(array($stmt, 'bind_result'), $fields);

                $i = 0;
                while ($stmt->fetch()) {
                    $numrows++;
                    $result[$i] = array();
                    foreach ($fields as $k => $v) {
                        $result[$i][$k] = $v;
                    }
                    $i++;
                }
            }

            $stmt->free_result();
        }
        return array(
            'state'         => $state,
            'numrows'       => $numrows,
            'result'        => $result,
            'affected_rows' => $affected_rows,
            'error'         => $error,
            'sql'           => $sql,
            'params'        => $paramsWithTypes
        );
    }

    public function disconnect() {
        $this->link->close();
    }

}
