<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body{font-family:Arial;background:#eef;}
.container{width:500px;margin:50px auto;background:white;padding:20px;border-radius:10px;text-align:center;}
a{margin:10px;display:inline-block;}
</style>
</head>
<body>

<div class="container">
<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<a href="view.php">📷 View Images</a>
<a href="logout.php">🚪 Logout</a>

<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="images[]" multiple required><br><br>
<button name="upload">Upload Images</button>
</form>
</div>

</body>
</html>