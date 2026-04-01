<?php
$file = "first.txt";
$content = "Hello, this is written to a file!";

file_put_contents($file, $content);

echo "File written successfully!";



?>