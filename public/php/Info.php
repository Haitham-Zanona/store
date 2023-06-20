<?php

trait Info{

    public function setAge($age){
        $this->age = $age;
        return $this;
    }
    //...
    function setGender($gender){
        $this->$gender;
        return $this;
    }



}


?>
