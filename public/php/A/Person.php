<?php

namespace A;
use B\Human;
use Info;
//define('AJYAL',true);
const LARAVEL = 'Laravel A';
class Person implements Human {
    use Info;

    const MALE = 'm';
    const FEMALE = 'f';
    public $name;
    protected $gender;
    private $age;

    public static $country;

    public function __construct(){
        /**
         *we can give the variable initial value in construct but we can't in definition line code.
         *$this->name = time();
        */
        echo __CLASS__;

    }


    public static function setCountry($country){
        self::$country = $country;
        self::MALE;
    }
}



?>
