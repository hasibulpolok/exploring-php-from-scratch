<?php
$username = "admin";
$password = "1234";

echo "<h2 style='color:blue;'>🔐 Hash Generator Result</h2>";

// MD5 Section
echo "<h3 style='color:green;'>MD5 Hash</h3>";
echo "Username: " . md5($username) . "<br>";
echo "Password: " . md5($password) . "<br>";
echo "<b>✔ md5() done</b><br><br>";

// SHA512 Section
echo "<h3 style='color:purple;'>SHA512 Hash</h3>";
echo "Username: " . hash("SHA512", $username) . "<br>";
echo "Password: " . hash("SHA512", $password) . "<br>";
echo "<b>✔ SHA512 hash done</b><br><br>";

// SHA256 Section
echo "<h3 style='color:orange;'>SHA256 Hash</h3>";
echo "Username: " . hash("SHA256", $username) . "<br>";
echo "Password: " . hash("SHA256", $password) . "<br>";
echo "<b>✔ SHA256 hash done</b><br>";
?>