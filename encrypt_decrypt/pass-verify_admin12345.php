<?php
$stored_hash = password_hash("admin123", PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login System</title>
    <style>
        body {
            font-family: Arial;
            background: #eef2f7;
            text-align: center;
        }
        .box {
            width: 300px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            padding: 10px;
            background: #1e88e5;
            color: white;
            border: none;
            width: 100%;
        }
    </style>
</head>

<body>

<div class="box">
    <h3>🔐 Login System</h3>

    <form method="post">
        <input type="password" name="pass" placeholder="Enter Password">
        <button type="submit">Login</button>
    </form>

    <?php
    if(isset($_POST['pass'])){
        $input = $_POST['pass'];

        if(password_verify($input, $stored_hash)){
            echo "<p style='color:green;'>✔ Login Success</p>";
        } else {
            echo "<p style='color:red;'>❌ Wrong Password</p>";
        }
    }
    ?>
</div>

</body>
</html>