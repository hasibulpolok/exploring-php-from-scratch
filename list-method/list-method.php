<?php

$person = [
    [1, 'Md Hasibul Bashar Polok', 27, 'hasibulpolok.bdn@gmail.com', '01765967395', 'Dhaka'],
    [2, 'Sanjida', 22, 'pakhia232@gmail.com', '01303272466', 'Dhaka'],
    [3, 'Saurav Hossain', 26, 'saurav@gmail.com', '01823456789', 'Gazipur'],
    [4, 'Mustafijur Rahman', 25, 'mustafijur@gmail.com', '01934567890', 'Khulna'],
    [5, 'Tanvir Ahmed', 28, 'tanvir@gmail.com', '01645678901', 'Chittagong'],
    [6, 'Nusrat Jahan', 24, 'nusrat@gmail.com', '01556789012', 'Rajshahi'],
    [7, 'Rakib Hasan', 29, 'rakib@gmail.com', '01367890123', 'Sylhet'],
    [8, 'Farhana Akter', 23, 'farhana@gmail.com', '01778901234', 'Barisal'],
    [9, 'Imran Khan', 30, 'imran@gmail.com', '01889012345', 'Comilla'],
    [10, 'Jannat Ara', 22, 'jannat@gmail.com', '01990123456', 'Rangpur'],
    [11, 'Shakib Al Hasan', 35, 'shakib@gmail.com', '01601234567', 'Magura']
];

foreach ($person as list($id, $name, $age, $email, $phone, $city)) {
    echo "ID: $id <br>";
    echo "Name: $name <br>";
    echo "Age: $age <br>";
    echo "Email: $email <br>";
    echo "Phone: $phone <br>";
    echo "City: $city <br><br>";
}

?>