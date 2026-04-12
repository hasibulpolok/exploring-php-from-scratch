<?php
$result= "";

if (isset($_POST['submit'])) {

    $num = $_POST['number'];

    if ($num <= 1) {
        $result = "Not a Prime Number";
    } else {
        $isPrime = true;

        for ($i = 2; $i <= $num / 2; $i++) {
            if ($num % $i == 0) {
                $isPrime = false;
                break;
            }
        }

        if ($isPrime) {
            $result = "Prime Number";
        } else {
            $result = "Not a Prime Number";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prime Number Check</title>
</head>
<body>

<h2>Check Prime Number</h2>

<form method="post">
    Enter a number: <input type="number" name="number" required><br><br>
    <button type="submit" name="submit">Check</button>
</form>

<?php
echo "<h3>Result: " . $result . "</h3>";
?>

</body>
</html> 