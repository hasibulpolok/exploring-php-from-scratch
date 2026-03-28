<?php
class Car{
    public $model = 'SUV';
    public $color = 'Black';
    public $name = 'BMW';
}

new Car();
$result = new Car();

$result->model;
echo $result->model;
// print_r(get_class_vars('Car'));