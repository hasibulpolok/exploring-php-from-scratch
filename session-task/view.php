<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$files = scandir("uploads");
?>

<h2>All Images</h2>

<?php
foreach($files as $file){
    if($file != "." && $file != ".."){
        echo "<img src='uploads/$file' width='150' style='margin:10px;'>";
    }
}
?>

<br><br>
<a href="dashboard.php">Back</a>