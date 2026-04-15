<?php
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $data = $username . "|" . $email . "|" . $pass . "\n";
    file_put_contents("users.txt", $data, FILE_APPEND);

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body{font-family:Arial; background:#f2f2f2;}
.box{width:300px;margin:100px auto;padding:20px;background:white;border-radius:10px;}
input,button{width:100%;padding:10px;margin:5px 0;}
button{background:green;color:white;border:none;}
</style>
</head>
<body>

<div class="box">
<h2>Register</h2>
<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Register</button>
</form>
<a href="login.php">Already have account?</a>
</div>

</body>
</html>