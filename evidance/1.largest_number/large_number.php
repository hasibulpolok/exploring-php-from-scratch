<?php
$largest= "";

if (isset($_POST['submit'])) {

    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $num3 = $_POST['num3'];

    if ($num1 >= $num2 && $num1 >= $num3) {
        $largest = $num1;
    } elseif ($num2 >= $num1 && $num2 >= $num3) {
        $largest = $num2;
    } else {
        $largest = $num3;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Largest Number</title>
</head>
<h2>Find Largest Number</h2>
<body>
<form  method="post">
    Number 1: <input type="number" name="num1" required><br><br>
    Number 2: <input type="number" name="num2" required><br><br>
    Number 3: <input type="number" name="num3" required><br><br>

    <button type="submit" name="submit">Submit</button>
</form>
<?php
echo "<h3>Largest Number is: " . $largest . "</h3>";      
?>
</body>

</html>