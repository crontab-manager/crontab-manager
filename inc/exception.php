<?php

class exceptionhandler {

    public static function handler($message,$e) {
        echo "CATCHED EXCEPTION\n";
        echo "================================================================================\n";
        echo "DATE: ".date('Y-m-d H:i:s')."\n";
        echo $message."!\n";
        echo "EXCEPTION: ".$e."\n";
        echo "================================================================================\n";
        exit(1);
    }

}