<?php

/**
 * Class CrontabParserTest
 */
class CrontabParserTest extends PHPUnit_Framework_TestCase {

    /**
     *
     */
    public function testCrontabLinesTrue() {
        foreach ($this->LinesToTest['true'] as $line) {
            $this->assertTrue($this->parse($line),$line);
        }
    }



    /**
     * @var array
     */
    private $LinesToTest = array(
        'true' => array(
            // '33 08 10 06 * /home/ramesh/full-backup'
            '* * * * * CMDramesh'
        ,
            '12-12 11,12,12 11,2,3 12,12,12 1,2,3 /home/ramesh/bin/incremental-backup'
            //,
            //'00 09-18 * * * /home/ramesh/bin/check-db-status',
            //'00 09-18 * * 1-5 /home/ramesh/bin/check-db-status',
            //'00     09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            //'00    09-18 *      * 1-5 /home/ramesh/bin/check-db-status', //tabs
            //'*/10 * * * * /home/ramesh/check-disk-space',
            //'* * * * * CMDramesh'

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


        ////  allgemeine Prüfung mit einem Wert pro Spalte
        //if (preg_match("/^(\*|[0-5]?[0-9])\s(\*|([0-1]?[0-9]|[2]?[0-3]))\s(\*|([0-1]?[0-9]|[3]?[0-1]))\s(\*|([0]?[0-9]|[1]?[0-2]))\s(\*|[0-6])\s.+$/",$line)){
        //    $valuereturn = true;
        //}

        //  allgemeine Prüfung mit gültigen Zahlenwerten, einem Wert pro Spalte und mit bis-Werten (Minus)
        // 1. Teil funktioniert
        //if (preg_match("/^(\*|[0-5]?[0-9]|([0-5]?[0-9])-([0-5]?[0-9])|([0-5]?[0-9])(,([0-5]?[0-9]))+)\s(\*|([0-1]?[0-9]|[2]?[0-3]))\s(\*|([0-1]?[0-9]|[3]?[0-1]))\s(\*|([0]?[0-9]|[1]?[0-2]))\s(\*|[0-6])\s.+$/",$line)){
        // 2. Teil funktioniert
        //if (preg_match("/^(\*|[0-5]?[0-9]|([0-5]?[0-9])-([0-5]?[0-9])|([0-5]?[0-9])(,([0-5]?[0-9]))+)\s(\*|([0-1]?[0-9]|[2]?[0-3])|(([0-1]?[0-9]|[2]?[0-3]))-(([0-1]?[0-9]|[2]?[0-3]))|(([0-1]?[0-9]|[2]?[0-3]))(,(([0-1]?[0-9]|[2]?[0-3])))+)\s(\*|([0]?[0-9]|[1]?[0-2]))\s(\*|[0-6])\s.+$/",$line)){
        // 3. und 4. Teil funktioniert
        //if (preg_match("/^(\*|[0-5]?[0-9]|([0-5]?[0-9])-([0-5]?[0-9])|([0-5]?[0-9])(,([0-5]?[0-9]))+)\s(\*|([0-1]?[0-9]|[2]?[0-3])|(([0-1]?[0-9]|[2]?[0-3]))-(([0-1]?[0-9]|[2]?[0-3]))|(([0-1]?[0-9]|[2]?[0-3]))(,(([0-1]?[0-9]|[2]?[0-3])))+)\s(\*|([1-2]?[0-9]|[3]?[0-1])|(([1-2]?[0-9]|[3]?[0-1]))-(([1-2]?[0-9]|[3]?[0-1]))|(([1-2]?[0-9]|[3]?[0-1]))(,(([1-2]?[0-9]|[3]?[0-1])))+)\s(\*|([0]?[0-9]|[1]?[0-2])|(([0]?[0-9]|[1]?[0-2]))-(([0]?[0-9]|[1]?[0-2]))|(([0]?[0-9]|[1]?[0-2]))(,(([0]?[0-9]|[1]?[0-2])))+)\s(\*|[0-6])\s.+$/",$line)){
        // 5. und letzter Teil funktioniert
        if (preg_match("/^(\*|[0-5]?[0-9]|([0-5]?[0-9])-([0-5]?[0-9])|([0-5]?[0-9])(,([0-5]?[0-9]))+)\s(\*|([0-1]?[0-9]|[2]?[0-3])|(([0-1]?[0-9]|[2]?[0-3]))-(([0-1]?[0-9]|[2]?[0-3]))|(([0-1]?[0-9]|[2]?[0-3]))(,(([0-1]?[0-9]|[2]?[0-3])))+)\s(\*|([1-2]?[0-9]|[3]?[0-1])|(([1-2]?[0-9]|[3]?[0-1]))-(([1-2]?[0-9]|[3]?[0-1]))|(([1-2]?[0-9]|[3]?[0-1]))(,(([1-2]?[0-9]|[3]?[0-1])))+)\s(\*|([0]?[0-9]|[1]?[0-2])|(([0]?[0-9]|[1]?[0-2]))-(([0]?[0-9]|[1]?[0-2]))|(([0]?[0-9]|[1]?[0-2]))(,(([0]?[0-9]|[1]?[0-2])))+)\s(\*|[0-6]|[0-6]-[0-6]|[0-6](,[0-6])+)\s.+$/",$line)){
            $valuereturn = true;
        }

        //  Versuch allgemeine Prüfung
        //if (preg_match("/^(\*|[0-5]?[0-9])\s(\*|([0-1]?[0-9]|[2]?[0-3])[,]([0-1]?[0-9]|[2]?[0-3]))\s[*]\s[*]\s[*]\s\/.+$/",$line)){
        //    $valuereturn = true;
        //}

        //Prüfung: Format '30 08 10 06 * /home/ramesh/full-backup'
        // // if (preg_match("/^\d{2}\s\d{2}\s\d{2}\s\d{2}\s[*]\s.\w+.\w+.\w+[-]\w+$/",$line)){
        // if (preg_match("/^\d{2}\s\d{2}\s\d{2}\s\d{2}\s[*]\s\/.+$/",$line)){
        //     $valuereturn = true;
        //}
        // //  Prüfung: Format '00 11,16 * * * /home/ramesh/bin/incremental-backup'
        // if (preg_match("/^(\*|(\d{1}|\d{2}))\s\d{2}[,]\d{2}\s[*]\s[*]\s[*]\s\/.+$/",$line)){
        //    $valuereturn = true;
        // }




        return $valuereturn;
    }


}
