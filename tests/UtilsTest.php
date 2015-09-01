<?php

/**
 * Class UtilsTest
 */
class UtilsTest extends PHPUnit_Framework_TestCase {

    public function testgetParamType() {
        $this->assertEquals('i',\exporter\utils\utils::getParamType((int)5));
        $this->assertEquals('s',\exporter\utils\utils::getParamType("i am a string"));
        $this->assertEquals('d',\exporter\utils\utils::getParamType((double)5.55));
    }

}