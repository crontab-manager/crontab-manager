<?php

/**
 * Class CrontabParserTest
 */
class CrontabParserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var array
     */
    private $LinesToTest = array(
        'true' => array(
            '30 08 10 06 * /home/ramesh/full-backup',
            '00 11,16 * * * /home/ramesh/bin/incremental-backup',
            '00 09-18 * * * /home/ramesh/bin/check-db-status',
            '00 09-18 * * 1-5 /home/ramesh/bin/check-db-status',
            '00     09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            '00    09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            '*/10 * * * * /home/ramesh/check-disk-space',
            '* * * * * CMD'
        ),
        'false' => array(
            '00 09-18 * *  /home/ramesh/bin/check-db-status',
            '*/10 a * * * /home/ramesh/check-disk-space',
            '* * * * * '
        )
    );

    /**
     * @param $line
     *
     * @return bool
     */
    private function parse($line) {
        return true;
    }

    /**
     *
     */
    public function testCrontabLinesTrue() {
        foreach ($this->LinesToTest['true'] as $line) {
            $this->assertTrue($this->parse($line),$line);
        }
    }


}
