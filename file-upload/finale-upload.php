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
        $filename = $_FILES['myfile']['name'];
        $tmp = $_FILES['myfile']['tmp_name'];
        $location = "uploads/";
        move_uploaded_file($tmp, $location . $filename);
    }

    ?>


</body>

</html>