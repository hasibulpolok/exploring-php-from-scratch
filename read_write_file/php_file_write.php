<?php
$newfile = fopen("store.txt", "w");
$text = "New text file created by php.";
fwrite($newfile, $text);
fclose($newfile);

echo "<br><br>";

// read
$read = fopen("store.txt", "r");
echo fread($read, filesize("store.txt"));
fclose($read);
?>