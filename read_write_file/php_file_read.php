<?php

// file rading 
$result = fopen('first.txt', 'r');

echo fread($result,filesize('first.txt'));
fclose($result);
?>