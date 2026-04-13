<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];


$file = file_get_contents("auth.txt");

list($stored_user, $stored_pass) = explode(",", trim($file));


if ($username === $stored_user && $password === $stored_pass) {
    $_SESSION['user'] = $username;
    header("Location: multi-upload.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>