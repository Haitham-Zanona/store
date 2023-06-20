<?php

class Facade
{
    protected static $container = 'person';

    public static function __callstatic($name, $arguments)
    {
    $person = ServiceContainer::make(self::$container);
    return $person->$name(...$arguments);

    }

    public function __set($name, $value){

    }

    function __get($name){

    }


}

?>
