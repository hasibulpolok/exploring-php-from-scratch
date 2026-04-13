<?php
session_start();


if (isset($_SESSION['user'])) {
    header("Location: fileuploads.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php


if (isset($POST['logout'])) {
    echo "<p style='color:green;'>Please login first</p>";
}
?>

<form action="authenticate.php" method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>

</body>
</html>