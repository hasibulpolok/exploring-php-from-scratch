<?php
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['upload'])) {

    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    foreach ($_FILES['images']['name'] as $key => $name) {

        $tmp = $_FILES['images']['tmp_name'][$key];
        $size = $_FILES['images']['size'][$key] / 1024; // KB
        $type = strtolower(pathinfo($name, PATHINFO_EXTENSION));


        $newName = time() . "_" . $name;
        $path = "uploads/" . $newName;

   
        if ($size <= 400) {

     
            if ($type == "jpg" || $type == "png") {

                if (move_uploaded_file($tmp, $path)) {
                    echo "<p style='color:green;'>Uploaded Successfully</p>";
                    echo "<img src='$path' width='150'><br>";
                } else {
                    echo "<p style='color:red;'>Upload Failed!</p>";
                }

            } else {
                echo "<p style='color:red;'>Only JPG and PNG allowed!</p>";
            }

        } else {
            echo "<p style='color:red;'>File too large (Max 400KB)</p>";
        }
    }

    echo "<br><a href='dashboard.php'>Back</a>";
}
?>