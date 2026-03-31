<?php
class Counter {
    public static $count = 0;

    public static function increment() {
        self::$count++;
    }
}


Counter::increment();
Counter::increment();

echo Counter::$count ."<br>"; 
?>


<?php 
class User{
    public static $name = "Hello world" ."<br>";
    const NAME = "Hello world" ."<br>";

    public static function info(){

    echo "This is a static method" ."<br>";
    }
}

echo User :: $name;
echo User :: NAME;
User :: info();
?>