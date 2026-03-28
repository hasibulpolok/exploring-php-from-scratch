<?php

class car
{
    public $name;
    public $color;

    public function __destruct()
    {
        echo "This is a destructor method<br>";
    }
    public function __construct()
    {
        echo "This is a constructor method<br>";
    }
}

$result =new car();