<?php

// file rading 
$result = fopen('first.txt', 'r') or die('File not found!');

echo fread($result,filesize('first.txt'));
fclose($result);
echo "<br><br>";
echo readfile("data.txt");
?>