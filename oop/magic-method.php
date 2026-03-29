<?php

class car
{
    public $name;
    public $color;

    public function __destruct()
    {
        echo "This is a destructor method<br>";
      
        echo "Color was: " . $this->color . "<br>";
    }
    public function __construct($n , $c)
    {
        $this->name = $n;
        echo "This is a constructor method<br>";
        echo "<br>";
            echo "<br>";
        echo "Hello, this " . $this->name = $n . " is " . $this->color = $c . "<br>";
        echo "<br>";
        echo "<br>";
    }
}

$result = new car("Toyota","Red");

