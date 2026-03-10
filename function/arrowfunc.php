<?php
$add = fn($a, $b) => $a + $b;

echo "The sum of two parameter is : " . $add(5,3);

echo "<br>";
$check = fn($a,$b) => $a > $b;

var_dump($check(10,5));



echo "<br>";

$compare = function($a,$b){
    if($a > $b){
        echo "A is greater";
    }else{
        echo "B is greater";
    }
};

$compare(2,5);

?>