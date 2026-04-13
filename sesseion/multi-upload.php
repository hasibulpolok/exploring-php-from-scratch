<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Multiple File Upload</title>
</head>

<body>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile[]" multiple>
    <input type="submit" value="Upload" name="submitbtn">
</form>

<?php
if (isset($_POST['submitbtn'])) {

    $location = "uploads/";


    echo "<div style='display:flex;flex-wrap:wrap;gap:10px;'>";

    foreach ($_FILES['myfile']['name'] as $key => $fileName) {

        $fileLocation = $_FILES['myfile']['tmp_name'][$key];
        $typ = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $size = $_FILES['myfile']['size'][$key] / 1024; // size in KB

        if ($size <= 1500) {
            if ($typ === "jpg" || $typ === "png") {

              
                move_uploaded_file($fileLocation, $location . $fileName);

            
                echo "<div style='flex:1 0 200px; display:flex; justify-content:center; align-items:center;'>";
                echo "<img src='" . $location . $fileName . "' width='200px'>";
                echo "</div>";

            } else {
                echo "<div style='color:red;'>Only JPG and PNG allowed: $fileName</div>";
            }
        } else {
            echo "<div style='color:red;'>File size must be less than 1500KB: $fileName</div>";
        }
    }

    echo "</div>";
}
?>

</body>
</html>