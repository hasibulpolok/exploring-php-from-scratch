<?php
$conn = new mysqli("localhost", "root", "", "shop_bd");

$sql = "SELECT * FROM manufacturer_view";
$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Country</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['country'] . "</td>";
    echo "</tr>";
}

echo "</table>";
