<?php
// includes/db.php – Database Connection

define('DB_HOST', 'localhost');
define('DB_USER', 'root');   // Change if needed
define('DB_PASS', '');       // Change if needed
define('DB_NAME', 'store_bd');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="font-family:sans-serif;color:red;padding:20px;">
         ❌ Database connection failed: ' . mysqli_connect_error() . '
         </div>');
}

mysqli_set_charset($conn, 'utf8mb4');
