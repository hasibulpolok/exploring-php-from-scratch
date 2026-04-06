<?php 
$text = "Hello Polok";

if(preg_match("/Polok/", $text)){
    echo "Match found";
}else{
    echo "Not found";
}

$text = "PHP is easy. PHP is powerful.";

preg_match_all("/PHP/", $text, $result);

print_r($result[0]);



?>