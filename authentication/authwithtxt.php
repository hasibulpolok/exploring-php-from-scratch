<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<style>
    form {
        display: flex;
        flex-direction: column;
        width: 300px;
        margin: auto;
        margin-top: 100px;
    }

    input {
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<body>

<form method="post">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <input type="submit" name="login" value="Login">
</form>

<?php

if (isset($_POST['login'])) {

    $user = $_POST['username'];
    $password = $_POST['password'];

    if (!file_exists("users.txt")) {
        echo "<h3 style='color:red;'>User file not found!</h3>";
        exit();
    }

    $lines = file("users.txt");
    $login = false;

    foreach ($lines as $line) {

        $data = explode(",", trim($line));

        if ($user === $data[0] && $password === $data[1]) {
            $login = true;
            break;
        }
    }

    if ($login) {
        header("Location: main.php");
        exit();
    } else {
       echo "<h3 style='color:red; text-align:center;'>Wrong username or password</h3>";
    }
}

?>

</body>
</html>