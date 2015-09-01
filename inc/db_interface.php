<?php
namespace exporter\db;

interface db_interface {

    public function connect();
    public function query($sql,array $params = array());
    public function disconnect();

}
