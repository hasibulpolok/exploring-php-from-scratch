<?php
class Car{
    public $model = 'SUV';
    public $color = 'Black';
    public $name = 'BMW';

    
    function info($c){
        echo "This is a car class ";
        echo '<br>';
        $this ->color;
    }
}

$result = new Car();
echo $result->model; 
echo "<br>";
echo $result->color;
echo "<br>";

$result->info("Red-Wine");

// print_r(get_class_vars('Car'));