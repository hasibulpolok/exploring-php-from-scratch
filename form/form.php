<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
</head>

<body>



<form action="" method="post">
    <label>User Name</label>
    <input type="text" name="uname" required> <br>
    <label>User Email</label>
    <input type="email" name="email" require> <br>

    <input type="submit" value="submit">
</form>
<?php
if(isset($_REQUEST['uname'])){
   echo "<br>";
   echo"User Name :";
     echo $_REQUEST['uname'];
}

if(isset($_REQUEST['email'])){
   echo "<br>";
   echo"User Email :";
     echo  $_REQUEST['email'];
}
?>
</body>
</html>