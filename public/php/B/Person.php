<?php

namespace B;

//define('AJYAL',true);
const LARAVEL = 'Laravel B';
class Person {

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
    public function setAge($age){
        $this->age = $age;
        return $this;
    }
    //...
    function setGender($gender){
        $this->$gender;
        return $this;
    }

    public static function setCountry($country){
        self::$country = $country;
        self::MALE;
    }
}



?>
