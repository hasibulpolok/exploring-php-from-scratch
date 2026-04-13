<?php
$password = "1234";

$hash = password_hash($password, PASSWORD_DEFAULT);


$input = "1234";

if(password_verify($input, $hash)){
    echo " Login Success";
} else {
    echo " Wrong Password";
}
?>