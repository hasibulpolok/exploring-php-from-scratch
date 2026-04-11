<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <style>
        h1{
            text-align: center;
        }
    </style>
</head>
<body>

<?php
date_default_timezone_set("Asia/Dhaka");

$currentHour = date("H");

if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Good Morning";
} elseif ($currentHour >= 12 && $currentHour < 17) {
    $greeting = "Good Afternoon";
} elseif ($currentHour >= 17 && $currentHour < 21) {
    $greeting = "Good Evening";
} else {
    $greeting = "Good Night";
}
?>

<h1><?php echo $greeting; ?>,  Admin</h1>

</body>
</html>