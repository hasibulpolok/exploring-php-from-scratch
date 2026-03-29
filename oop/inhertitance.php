<?php


class Animal {
    protected $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function eat() {
        echo "{$this->name} is eating.\n";
        echo "<br>";
    }
}
class Dog extends Animal {
    public function bark() {
        echo "{$this->name} is barking: Woof! Woof!\n";
        echo "<br>";
    }
}


$dog = new Dog("Buddy");
$dog->eat();   
$dog->bark();  

?>