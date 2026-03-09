<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Form</title>

<style>

.container{
    width: 500px;
    margin: 80px auto;
    padding: 30px;
    background: white;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

label{
    font-size: 18px;
}

input[type="text"]{
    width: 80%;
    padding: 10px;
    margin-top: 10px;
    font-size: 16px;
}

input[type="submit"]{
    margin-top: 20px;
    padding: 10px 25px;
    font-size: 16px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover{
    background-color: #f50d66;
}

.message{
    margin-top: 30px;
    font-size: 40px;
    color: red;
    text-align: center;
}

</style>

</head>

<body>

<div class="container">

<form action="" method="get">

<label for="name">Name</label><br>

<input type="text" name="name" id="name">

<br>

<input type="submit" value="Submit">

</form>

</div>

<?php

if(isset($_GET['name'])){

    if($_GET['name']==""){
        echo "<p class='message'>Enter a name</p>";
    }
    else{
        $store=$_GET['name'];
        echo "<p class='message'>Name : $store</p>";
    }

}

?>

</body>
</html>