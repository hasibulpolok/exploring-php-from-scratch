<?php

$person = [
    [1, 'Md Hasibul Bashar Polok', 27, 'hasibulpolok.bdn@gmail.com', '01765967395', 'Dhaka'],
    [2, 'Saurav Hossain', 26, 'saurav@gmail.com', '01823456789', 'Gazipur'],
    [3, 'Mustafijur Rahman', 25, 'mustafijur@gmail.com', '01934567890', 'Khulna'],
    [4, 'Tanvir Ahmed', 28, 'tanvir@gmail.com', '01645678901', 'Chittagong'],
    [5, 'Nusrat Jahan', 24, 'nusrat@gmail.com', '01556789012', 'Rajshahi'],
    [6, 'Rakib Hasan', 29, 'rakib@gmail.com', '01367890123', 'Sylhet'],
    [7, 'Farhana Akter', 23, 'farhana@gmail.com', '01778901234', 'Barisal'],
    [8, 'Imran Khan', 30, 'imran@gmail.com', '01889012345', 'Comilla'],
    [9, 'Jannat Ara', 22, 'jannat@gmail.com', '01990123456', 'Rangpur'],
    [10, 'Shakib Al Hasan', 35, 'shakib@gmail.com', '01601234567', 'Magura']
];

foreach ($person as list($id, $name, $age, $email, $phone, $city)) {
    echo "$id | $name | $age | $email | $phone | $city <br>";
}

?>