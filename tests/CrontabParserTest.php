<?php

/**
 * Class CrontabParserTest
 */
class CrontabParserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var $Parser exporter\parser\parser
     */
    private $Parser;


    public function setUp() {
        $this->Parser = new exporter\parser\parser();
    }

    private function AssertArrayCountTrue(array $array, $count, $elementtotest) {
        if (count($array) == $count) {
            $this->assertTrue(true);
        }
        else {
            $this->assertTrue(false,$elementtotest);
        }
    }

    private function AssertArrayCountFalse(array $array, $elementtotest) {
        if (count($array) > 1) {
            $this->assertFalse(true,$elementtotest);
        }
        else {
            $this->assertFalse(false);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementMinutesTrue() {
        foreach ($this->ElementsToTest['min']['true'] as $elementtotest) {
            // $this->assertTrue($this->CheckElement($elementtotest,$this->regexmin), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexmin);
            $this->AssertArrayCountTrue($matches,2,$elementtotest);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementMinutesFalse() {
        foreach ($this->ElementsToTest['min']['false'] as $elementtotest) {
            // $this->assertTrue($this->CheckElement($elementtotest,$this->regexmin), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexmin);
            $this->AssertArrayCountFalse($matches,$elementtotest);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementHoursTrue() {
        foreach ($this->ElementsToTest['hrs']['true'] as $elementtotest) {
            //$this->assertTrue($this->CheckElement($elementtotest,$this->regexhrs), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexhrs);
            $this->AssertArrayCountTrue($matches,2,$elementtotest);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementHoursFalse() {
        foreach ($this->ElementsToTest['hrs']['false'] as $elementtotest) {
            //$this->assertFalse($this->CheckElement($elementtotest,$this->regexhrs), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexhrs);
            $this->AssertArrayCountFalse($matches,$elementtotest);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementDomTrue() {
        foreach ($this->ElementsToTest['dom']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexdom), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexdom);
            $this->AssertArrayCountTrue($matches,2,$elementtotest);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementDomFalse() {
        foreach ($this->ElementsToTest['dom']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexdom), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexdom);
            $this->AssertArrayCountFalse($matches,$elementtotest);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementMonTrue() {
        foreach ($this->ElementsToTest['mon']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexmon), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexmon);
            $this->AssertArrayCountTrue($matches,2,$elementtotest);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementMonFalse() {
        foreach ($this->ElementsToTest['mon']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexmon), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexmon);
            $this->AssertArrayCountFalse($matches,$elementtotest);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementDowTrue() {
        foreach ($this->ElementsToTest['dow']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexdow), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexdow);
            $this->AssertArrayCountTrue($matches,2,$elementtotest);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementDowFalse() {
        foreach ($this->ElementsToTest['dow']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexdow), $elementtotest);
            $matches = $this->CheckElement($elementtotest,\exporter\regex::$regexdow);
            $this->AssertArrayCountFalse($matches,$elementtotest);
        }
    }

    /**
     *
     */
    public function testCrontabLinesTrue() {
        foreach ($this->LinesToTest['true'] as $line) {
            $this->assertTrue($this->Parser->parseLine($line)['state'],$line);
        }
    }

    /**
     *
     */
    public function testCrontabLinesFalse() {
        foreach ($this->LinesToTest['false'] as $line) {
            $this->assertFalse($this->Parser->parseLine($line)['state'],$line);
        }
    }


//    public function testParsedCrontab() {
//        $matches = $this->Parser->getParsedCrontab("#1234\n* * * * * /test.sh","testserver");
//        $this->AssertArrayCountTrue($matches);
//    }

    private $ElementsToTest = array(
        'min' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*',
                '*/15',
                '*/0',
                '*/59',
            ),
            'false' => array(
                '69',
                'a',
                '*/99'
            )
        ),
        'hrs' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*'
            ),
            'false' => array(
                '99',
                'a'
            )
        ),
        'dom' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*'
            ),
            'false' => array(
                '99',
                'a'
            )
        ),
        'mon' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*'
            ),
            'false' => array(
                '99',
                'a'
            )
        ),
        'dow' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*',
                '*/5'
            ),
            'false' => array(
                '99',
                'a'
            )
        )
    );


    /**
     * @var array
     */
    private $LinesToTest = array(
        'true' => array(
            // '33 08 10 06 * /home/ramesh/full-backup'
            '12-12 11,12,12 11,2,3 12,12,12 1,2,3 /home/ramesh/bin/incremental-backup',
            '00     09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            '00 09-18 * * * /home/ramesh/bin/check-db-status',
            '00 09-18 * * 1-5 /home/ramesh/bin/check-db-status',
            '00     09-18 *      * 1-5 /home/ramesh/bin/check-db-statusn && echo "  test  "', //tabs
            '00    09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            '10 * * * * /home/ramesh/check-disk-space',
            '* * * * * CMDramesh',
            '* * * * * CMDramesh #test1234'
        ),
        'false' => array(
            '00 09-18 * *  /home/ramesh/bin/check-db-status',
            '*/10 a * * * /home/ramesh/check-disk-space',
            '* * * * * ',
        )
    );

    /**
     * @param $elementtotest
     * @param $regex
     * @return array
     * @internal param $elementtype
     * @internal param $elementmin
     */
    private Function CheckElement($elementtotest,$regex) {
        if ($regex){
            if (preg_match('/^(' . $regex . ')$/',$elementtotest,$matches)) {
                return $matches;
            }
        }
        return array();
    }

    /**
     * @var array
     */
    private $LinesToTestinactive = array(
        'true' => array(
            '#123# * * * * * CMDramesh',
            '## tmp deaktiviert ## * * * * * echo "test"'
        ),
        'false' => array(
            '#tmp deaktiviert#',
            '##34254## * * '
        )
    );

    private $LinesToTestWithComment = array(
        'true' => array(
            '* * * * * CMDramesh #123',
            '* * * * * CMDramesh ### 123'
        ),
        'false' => array(
            '##34254## * * ',
            '* * * * * CMDramesh'
        )
    );

    private $LinesToTestInactiveWithComment = array(
        'true' => array(
            '#123# * * * * * CMDramesh #123',
            '### 13444 ##* * * * * CMDramesh ### 123'
        ),
        'false' => array(
            '##34254## * * ',
            '* * * * * CMDramesh'
        )
    );

    /**
     *
     */
    public function testCrontabLinesInactiveTrue() {
        foreach ($this->LinesToTestinactive['true'] as $line) {
            //$this->assertTrue($this->Parser->parseLine($line)['state'],$line);
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertTrue($parseLineInactive['job'] == "inactive command");
        }
    }

    /**
     *
     */
    public function testCrontabLinesInactiveFalse() {
        foreach ($this->LinesToTestinactive['false'] as $line) {
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertFalse($parseLineInactive['job'] == "inactive command");
        }
    }

    /**
     *
     */
    public function testCrontabLinesWithCommentTrue() {
        foreach ($this->LinesToTestWithComment['true'] as $line) {
            //$this->assertTrue($this->Parser->parseLine($line)['state'],$line);
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertTrue($parseLineInactive['job'] == "command with comment");
        }
    }

    /**
     *
     */
    public function testCrontabLinesWithCommentFalse() {
        foreach ($this->LinesToTestWithComment['false'] as $line) {
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertFalse($parseLineInactive['job'] == "command with comment");
        }
    }
    /**
     *
     */
    public function testCrontabLinesInactiveWithCommentTrue() {
        foreach ($this->LinesToTestInactiveWithComment['true'] as $line) {
            //$this->assertTrue($this->Parser->parseLine($line)['state'],$line);
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertTrue($parseLineInactive['job'] == "inactive command with comment");
        }
    }

    /**
     *
     */
    public function testCrontabLinesInactiveWithCommentFalse() {
        foreach ($this->LinesToTestInactiveWithComment['false'] as $line) {
            $parseLineInactive = $this->Parser->parseLine($line);
            $this->assertFalse($parseLineInactive['job'] == "inactive command with comment");
        }
    }
}
