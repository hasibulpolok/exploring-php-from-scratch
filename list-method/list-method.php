<?php

$person = [
    [1, 'Md Hasibul Bashar Polok', 27, 'hasibulpolok.bdn@gmail.com', '01765967395', 'Dhaka'],
    [2, 'Saurav Hossain', 26, 'saurav@gmail.com', '01823456789', 'Gazipur'],
    [3, 'Mustafijur Rahman', 25, 'mustafijur@gmail.com', '01934567890', 'Khulna'],
    [4, 'Tanvir Ahmed', 28, 'tanvir@gmail.com', '01645678901', 'Chittagong'],
    [5, 'Nusrat Jahan', 24, 'nusrat@gmail.com', '01556789012', 'Rajshahi']
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