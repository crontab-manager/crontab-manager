<?php
namespace exporter\utils;

class utils {

    public static function getParamType($value) {
        if (is_int($value)) {
            return 'i';
        } elseif (is_string($value)) {
            return 's';
        } elseif (is_double($value)) {
            return 'd';
        }
    }

}