<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Form</title>
</head>

<body>

<form action="" method="get">
<label for="name">Name</label>
<input type="text" name="name" id="name">
<input type="submit" value="Submit">

</form>

<?php

if(isset($_GET['name'])){
    $store = $_GET['name'];
    echo "<br>";
    echo "Your Entered Name Is: ".$store;
    
}

?>

</body>
</html>