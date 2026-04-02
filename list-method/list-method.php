<?php

$person = [
    ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'phone' => '555-0101', 'city' => 'New York'],
    ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com', 'phone' => '555-0102', 'city' => 'Los Angeles'],
    ['id' => 3, 'name' => 'Bob', 'email' => 'bob@example.com', 'phone' => '555-0103', 'city' => 'Chicago'],
    ['id' => 4, 'name' => 'Alice', 'email' => 'alice@example.com', 'phone' => '555-0104', 'city' => 'Houston'],
    ['id' => 5, 'name' => 'Charlie', 'email' => 'charlie@example.com', 'phone' => '555-0105', 'city' => 'Phoenix'],
    ['id' => 6, 'name' => 'Diana', 'email' => 'diana@example.com', 'phone' => '555-0106', 'city' => 'Philadelphia'],
    ['id' => 7, 'name' => 'Eve', 'email' => 'eve@example.com', 'phone' => '555-0107', 'city' => 'San Antonio'],
    ['id' => 8, 'name' => 'Frank', 'email' => 'frank@example.com', 'phone' => '555-0108', 'city' => 'San Diego'],
    ['id' => 9, 'name' => 'Grace', 'email' => 'grace@example.com', 'phone' => '555-0109', 'city' => 'Dallas'],
    ['id' => 10, 'name' => 'Henry', 'email' => 'henry@example.com', 'phone' => '555-0110', 'city' => 'San Jose']
];

foreach ($person as list($id, $name, $age)) {
    echo "ID: $id, Name: $name, Age: $age";
}

?>