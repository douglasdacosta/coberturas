<?php

namespace AppBundle\Services;

class FieldsValidations {
    
    public static function onlyNumbers($number) {        
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }
    
    public static function numeric($number) {        
        $number = preg_replace('/[^0-9,]/', '', $number);
        return $number;
    }
    
    public static function numericToSave($number) {        
        $number = preg_replace('/,/', '.', preg_replace('/[^0-9,]/', '', $number));
        return $number;
    }
    public static function numericToView($number) {     
        $number = preg_replace('/\./', ',', $number);
        return $number;
    }
    public static function dateToSave($date) {     
        $date = implode('-',array_reverse(explode('/', $date)));
        return new \DateTime($date);
    }
    public static function dateToView($date) {     
        $date = implode('/',array_reverse(explode('-', $date)));
        return $date;
    }
}
