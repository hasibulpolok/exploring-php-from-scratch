<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Object</title>
</head>

<body>
    <?php
    class Student2
    {
        public $name = "Pookie";
    }
    $obj2 = new Student2();
    echo "<br>";  echo "<br>";
    echo $obj2->name;
    echo "<br>";  echo "<br>";
    var_dump($obj2);
     echo "<br>"; echo "<br>";
    print_r($obj2);
    ?>

</body>

</html>