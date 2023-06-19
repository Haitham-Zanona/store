<?php
include __DIR__ . '/A/Person.php';
include __DIR__ . '/B/Person.php';
$person = new A\Person;
$person2 = new B\Person;

$person->name = 'Mohamed';
$person2->name = 'Ali';
////////////////////////////////////////////////////////
/*
*  We can use :: when one of two parts is static
*  Person::$country = 'Palestine';
*  When you call a static methods and give it a value that value for the class itself and any object extends from the class
*/
$person::$country = 'Palestine';
$person2::$country = 'Jordan';
echo '<pre>';
var_dump($person,$person2);
echo '</pre>';
echo '<br>';
echo $person::$country;
echo '<br>';

/**
 *You can call a constant either two ways class static method or object static method
 *
 * echo Person::MALE;
 * echo '<br>';
 * echo $person::FEMALE;
 */



?>
