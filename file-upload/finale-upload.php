<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php File Upload</title>
</head>

<body>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile">
    <input type="submit" value="Upload" name="submitbtn">
</form>

<?php
if (isset($_POST['submitbtn'])) {

    $fileName = $_FILES['myfile']['name'];
    $fileLocation = $_FILES['myfile']['tmp_name'];
    $typ = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
   $size = $_FILES['myfile']['size'] / 1024; 
    $location = "uploads/";

    if ($size <= 400) {
        if ($typ === "jpg" || $typ === "png") {
            move_uploaded_file($fileLocation, $location . $fileName);
            echo "<br>";
            echo "<img src='" . $location . $fileName . "' alt='image' width='400px'>";
        } else {
            echo "Only JPG and PNG allowed!";
        }
    } else {
        echo "File size must be less than 400KB";
    }
}
?>

</body>
</html>