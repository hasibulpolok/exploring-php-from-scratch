<?php
session_start();

// 👉 fake user 
$stored_username = "admin";


$stored_password = password_hash("1234", PASSWORD_DEFAULT);

// login check
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $stored_username && password_verify($password, $stored_password)) {
        $_SESSION['user'] = $username;
    } else {
        $error = "❌ Wrong username or password";
    }
}

//  logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: single.php");
}
?>

<!DOCTYPE html>
<html>
<body>

<?php if (isset($_SESSION['user'])): ?>

    <h2>✅ Welcome <?php echo $_SESSION['user']; ?></h2>
    <a href="?logout=true">Logout</a>

<?php else: ?>

    <h2>Login</h2>

    <?php if (isset($error)) echo $error; ?>

    <form method="POST">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit" name="login">Login</button>
    </form>

<?php endif; ?>

</body>
</html>