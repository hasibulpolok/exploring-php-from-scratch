<?php
$password = "1234";

$hash = password_hash($password, PASSWORD_DEFAULT);

$input = "1234";

echo "Password Verify:<br><br>";

if (password_verify($input, $hash)) {
    echo "Valid<br><br>";
} else {
    echo "Invalid<br><br>";
}

echo "SHA256:<br><br>";

echo hash("SHA256", $password) . "<br><br>";

$encoded = base64_encode($password);

echo "Base64 Encoded:<br><br>";

echo $encoded . "<br><br>";

$decoded = base64_decode($encoded);

echo "Base64 Decoded:<br><br>";

echo $decoded . "<br><br>";
?>