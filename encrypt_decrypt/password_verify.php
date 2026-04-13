<?php
$password = "1234";

// password hash create
$hash = password_hash($password, PASSWORD_DEFAULT);

// user input
$input = "1234";

// verify check
if(password_verify($input, $hash)){
    echo "✔ Login Success";
} else {
    echo "❌ Wrong Password";
}
?>