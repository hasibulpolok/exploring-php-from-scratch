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

$email = "test@gmail.com";

if(preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/", $email)){
    echo "Valid Email";
}else{
    echo "Invalid Email";
}

?>