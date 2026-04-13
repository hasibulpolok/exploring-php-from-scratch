<?php
$username = "admin";
$password="1234";

echo md5($username) . "\n";
echo md5($password);

echo "md5 () done" ."\n";

echo hash("SHA512",$username) . "\n";
echo hash("SHA512",$password) . "\n";

echo ("SHA512 hash") . "\n";

echo hash("SHA256",$username) . "\n";
echo hash("SHA256",$password) . "\n";

echo ("SHA256 hash") . "\n";



?>