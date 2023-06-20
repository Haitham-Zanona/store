<?php

class ServiceContainer
{
    protected static $container = [];

    public function bind($name, $instance)
    {

    $this->container[$name] = $instance;
    }

    function make($name){

        return $this->container[$name] ;
    }


}
