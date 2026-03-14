<!DOCTYPE html>
<html>
<head>
    <title>Marks Grade System</title>
</head>
<body>

<h2>Enter Your Marks</h2>

<form method="post">
    <input type="number" name="marks" placeholder="Enter marks">
    <button type="submit">Check Grade</button>
</form>

<?php

if(isset($_POST['marks'])){

    $marks = $_POST['marks'];

    if($marks >= 80){
        echo "Grade: A+";
    }
    elseif($marks >= 70){
        echo "Grade: A";
    }
    elseif($marks >= 60){
        echo "Grade: A-";
    }
    elseif($marks >= 50){
        echo "Grade: D";
    }
    else{
        echo "Grade: F";
    }

}

?>

</body>
</html>