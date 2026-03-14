<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
</head>
<body>
<header>
    <h1>আমার ওয়েবসাইটে স্বাগতম</h1>
    <nav>
        <a href="index.php">Home</a> |
        <a href="#">About</a> |
        <a href="#">Contact</a>
    </nav>
    <hr>

    <?php
// header include
include 'header.php';
?>

<main>
    <h2>মেইন কন্টেন্ট</h2>
    <p>এইখানে আপনার ওয়েবসাইটের প্রধান তথ্য থাকবে।</p>
</main>

<?php
// footer include
include 'footer.php';
?>
</header>