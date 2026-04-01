<?php

// file rading 
$result = fopen('first.txt', 'r') or die('Unable to open file!');

echo fread($result,filesize('first.txt'));
fclose($result);
?>