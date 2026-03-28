<?php
class Car{
    public $model = 'SUV';
    public $color = 'Black';
    public $name = 'BMW';

    function info($c){
        echo "This is a car class<br>";
        echo "Color: " . $this->color . "<br>";
        echo "Passed color: " . $c . "<br>";
    }
}

$result = new Car();

echo $result->model;
echo "<br>";
echo $result->color;   
echo "<br>";

$result->info("Red-Wine");