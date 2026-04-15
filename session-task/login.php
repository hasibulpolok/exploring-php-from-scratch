<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $users = file("users.txt");

    foreach($users as $user){
        $data = explode("|", trim($user));

        if($data[1] == $email && $data[2] == $pass){
            $_SESSION['user'] = $data[0];
            header("Location: dashboard.php");
            exit();
        }
    }

    $error = "Login Failed!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{font-family:Arial;background:#f2f2f2;}
.box{width:300px;margin:100px auto;padding:20px;background:white;border-radius:10px;}
input,button{width:100%;padding:10px;margin:5px 0;}
button{background:blue;color:white;border:none;}
.error{color:red;}
</style>
</head>
<body>

<div class="box">
<h2>Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="post">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<a href="register.php">Create account</a>
</div>

</body>
</html>