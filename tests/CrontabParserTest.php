<?php

/**
 * Class CrontabParserTest
 */
class CrontabParserTest extends PHPUnit_Framework_TestCase {


    //matches minutes 2 or 0-5 or * or 1,2 or */5
    private $regexmin = '(?:\*|[0-5]?[0-9]|(?:[0-5]?[0-9])-(?:[0-5]?[0-9])|(?:[0-5]?[0-9])(?:,(?:[0-5]?[0-9]))+)';

    //matches hours 2 or 0-5 or * or 1,2 or */5
    private $regexhrs = '(?:\*|(?:[0-1]?[0-9]|[2]?[0-3])|(?:(?:[0-1]?[0-9]|[2]?[0-3]))-(?:(?:[0-1]?[0-9]|[2]?[0-3]))|(?:(?:[0-1]?[0-9]|[2]?[0-3]))(?:,(?:(?:[0-1]?[0-9]|[2]?[0-3])))+)';

    //matches day of month 2 or 0-5 or * or 1,2 or */5
    private $regexdom = '(?:\*|(?:[1-2]?[0-9]|[3]?[0-1])|(?:(?:[1-2]?[0-9]|[3]?[0-1]))-(?:(?:[1-2]?[0-9]|[3]?[0-1]))|(?:(?:[1-2]?[0-9]|[3]?[0-1]))(?:,(?:(?:[1-2]?[0-9]|[3]?[0-1])))+)';

    //matches month 2 or 0-5 or * or 1,2 or */5
    private $regexmon = '(?:\*|(?:[0]?[0-9]|[1]?[0-2])|(?:(?:[0]?[0-9]|[1]?[0-2]))-(?:(?:[0]?[0-9]|[1]?[0-2]))|(?:(?:[0]?[0-9]|[1]?[0-2]))(?:,(?:(?:[0]?[0-9]|[1]?[0-2])))+)';

    //matches day of week 2 or 0-5 or * or 1,2 or */5
    private $regexdow = '(?:\*|[0-6]|[0-6]-[0-6]|[0-6](?:,[0-6])+)';


    private function AssertArrayCountTrue(array $array, $count) {
        if (count($array) == $count) {
            $this->assertTrue(true);
        }
        else {
            $this->assertTrue(false);
        }
    }

    private function AssertArrayCountFalse(array $array) {
        if (count($array) > 1) {
            $this->assertFalse(true);
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
            $matches = $this->CheckElement($elementtotest,$this->regexmin);
            $this->AssertArrayCountTrue($matches,2);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementMinutesFalse() {
        foreach ($this->ElementsToTest['min']['false'] as $elementtotest) {
            // $this->assertTrue($this->CheckElement($elementtotest,$this->regexmin), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexmin);
            $this->AssertArrayCountFalse($matches);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementHoursTrue() {
        foreach ($this->ElementsToTest['hrs']['true'] as $elementtotest) {
            //$this->assertTrue($this->CheckElement($elementtotest,$this->regexhrs), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexhrs);
            $this->AssertArrayCountTrue($matches,2);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementHoursFalse() {
        foreach ($this->ElementsToTest['hrs']['false'] as $elementtotest) {
            //$this->assertFalse($this->CheckElement($elementtotest,$this->regexhrs), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexhrs);
            $this->AssertArrayCountFalse($matches);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementDomTrue() {
        foreach ($this->ElementsToTest['dom']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexdom), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexdom);
            $this->AssertArrayCountTrue($matches,2);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementDomFalse() {
        foreach ($this->ElementsToTest['dom']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexdom), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexdom);
            $this->AssertArrayCountFalse($matches);
        }
    }
    /**
     * @group element
     */
    public function testCrontabElementMonTrue() {
        foreach ($this->ElementsToTest['mon']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexmon), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexmon);
            $this->AssertArrayCountTrue($matches,2);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementMonFalse() {
        foreach ($this->ElementsToTest['mon']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexmon), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexmon);
            $this->AssertArrayCountFalse($matches);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementDowTrue() {
        foreach ($this->ElementsToTest['dow']['true'] as $elementtotest) {
//            $this->assertTrue($this->CheckElement($elementtotest,$this->regexdow), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexdow);
            $this->AssertArrayCountTrue($matches,2);
        }
    }

    /**
     * @group element
     */
    public function testCrontabElementDowFalse() {
        foreach ($this->ElementsToTest['dow']['false'] as $elementtotest) {
//            $this->assertFalse($this->CheckElement($elementtotest,$this->regexdow), $elementtotest);
            $matches = $this->CheckElement($elementtotest,$this->regexdow);
            $this->AssertArrayCountFalse($matches);
        }
    }

    /**
     *
     */
    public function testCrontabLinesTrue() {
        foreach ($this->LinesToTest['true'] as $line) {
            $this->assertTrue($this->parse($line),$line);
        }
    }

    /**
     *
     */
    public function testCrontabLinesFalse() {
        foreach ($this->LinesToTest['false'] as $line) {
            $this->assertFalse($this->parse($line),$line);
        }
    }

    private $ElementsToTest = array(
        'min' => array(
            'true' => array(
                '0-5',
                '1,3,5',
                '*'
            ),
            'false' => array(
                '69',
                'a'
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
                '*'
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
            '* * * * * CMDramesh'
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
         $valuereturn = false;

        $regex = '/^(' . $this->regexmin . ')\s(' . $this->regexhrs. ')\s(' . $this->regexdom . ')\s(' . $this->regexmon . ')\s(' . $this->regexdow . ')\s(.+)$/';
        // $regex = "/^(\*|[0-5]?[0-9]|([0-5]?[0-9])-([0-5]?[0-9])|([0-5]?[0-9])(,([0-5]?[0-9]))+)". // matches minutes: 2 or 0-59 or * or 1,2 or */10
        // "\s(\*|([0-1]?[0-9]|[2]?[0-3])|(([0-1]?[0-9]|[2]?[0-3]))-(([0-1]?[0-9]|[2]?[0-3]))|(([0-1]?[0-9]|[2]?[0-3]))(,(([0-1]?[0-9]|[2]?[0-3])))+)". //matches minutes: 2 or 0-10 or * or 1,2 or */10
        // "\s(\*|([1-2]?[0-9]|[3]?[0-1])|(([1-2]?[0-9]|[3]?[0-1]))-(([1-2]?[0-9]|[3]?[0-1]))|(([1-2]?[0-9]|[3]?[0-1]))(,(([1-2]?[0-9]|[3]?[0-1])))+)". //3. part: day of month (0-31)
        // "\s(\*|([0]?[0-9]|[1]?[0-2])|(([0]?[0-9]|[1]?[0-2]))-(([0]?[0-9]|[1]?[0-2]))|(([0]?[0-9]|[1]?[0-2]))(,(([0]?[0-9]|[1]?[0-2])))+)". //4. part: month (1-12)
        // "\s(\*|[0-6]|[0-6]-[0-6]|[0-6](,[0-6])+)". // 5. part: day of week (0-6)
        // "\s.+$/"; // 6. part: command

        $line = preg_replace('/\s\s+/', ' ', $line);

        if (preg_match($regex,$line,$matches)) {
            print_r($matches);
            $valuereturn = true;
        }

        return $valuereturn;
    }

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

}
