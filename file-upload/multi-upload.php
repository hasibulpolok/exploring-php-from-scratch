<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php File Upload</title>
</head>

<body>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile[]" multiple>
    <input type="submit" value="Upload" name="submitbtn">
</form>

<?php
if (isset($_POST['submitbtn'])) {

    $location = "uploads/";

    foreach ($_FILES['myfile']['name'] as $key => $fileName) {

        $fileLocation = $_FILES['myfile']['tmp_name'][$key];
        $typ = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $size = $_FILES['myfile']['size'][$key] / 1024;

        if ($size <= 1500) {
            if ($typ === "jpg" || $typ === "png") {
                move_uploaded_file($fileLocation, $location . $fileName);
                echo "<br>";
                echo "<img src='" . $location . $fileName . "' width='400px'>";
            } else {
                echo "<br>Only JPG and PNG allowed!";
            }
        } else {
            echo "<br>File size must be less than 1500KB";
        }
    }
}
?>

</body>
</html>