<?php
class Car{
    public $model = 'SUV';
    public $color = 'Black';
    public $name = 'BMW';

    
    function info(){
        echo "This is a car class";
    }
}

$result = new Car();
echo $result->model;
echo "<br>";

$result->info();
// print_r(get_class_vars('Car'));