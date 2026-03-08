<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GB PHP</title>
</head>

<body>

<?php

$x = 20; // global variable

function test()
{
    global $x;
    echo "<h3>Value: $x</h3>";
}

test();

function add (){
    $y = 23;
    global $x;
    echo $x + $y;
}
echo "The sum of x + y = "; 
add();

echo "<br>";

function counter() {
    static $x = 0;
    $x++;
    echo $x . "<br>";
}

counter();
counter();
counter();

?>

</body>
</html>