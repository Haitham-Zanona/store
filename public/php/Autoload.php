<?php

/**
 * You can call a function like normal way
 */
/* function load_class($className){
    include __DIR__ . "/{$className}.php";
}

spl_autoload_register('load_class'); */


/**
 * OR you can define a function like this
 * Name that a Closure function(Function inside function without function name)
 */

/* spl_autoload_register(function ($className){
    include __DIR__ . "/{$className}.php";
});*/

class Autoload
{
    public static function register($className){
        include __DIR__ . "/{$className}.php";
    }
}


spl_autoload_register([Autoload::class, 'register']);





?>
