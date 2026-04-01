<!DOCTYPE html>
<html>
<head>
    <title>Find Largest Number</title>
</head>
<body>

<h2>Find Largest Number</h2>

<form method="get" action="">
    Number 1: <input type="number" name="num1" required><br><br>
    Number 2: <input type="number" name="num2" required><br><br>
    Number 3: <input type="number" name="num3" required><br><br>
    <input type="submit" value="Find Largest">
</form>

<?php
if (isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['num3'])) {
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
    $num3 = $_GET['num3'];

   
    if ($num1 >= $num2 && $num1 >= $num3) {
        $largest = $num1;
    } elseif ($num2 >= $num1 && $num2 >= $num3) {
        $largest = $num2;
    } else {
        $largest = $num3;
    }

    echo "<h3>Largest number is: $largest</h3>";
}
?>

</body>
</html>