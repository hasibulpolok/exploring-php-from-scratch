<?php 
$text = "Hello Polok";

if(preg_match("/Polok/", $text)){
    echo "Match found";
}else{
    echo "Not found";
}
?>