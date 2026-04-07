<?php
$data = "A1b2"; 
$pattern = "/^[a-zA-Z0-9]{3,8}$/";

echo preg_match_all($pattern, $data) ? "True " : "False ";
?>