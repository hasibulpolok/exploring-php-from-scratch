<?php

// file rading 
$result = fopen('first.txt', 'r') or die('File not found!');

echo fread($result,filesize('first.txt'));
fclose($result);
echo "<br><br>";
echo readfile("data.txt") or die("File not found!");

echo "<br><br>";

 $file_get = file_get_contents("fileget.txt") or die("File not found!");
echo $file_get;
?>