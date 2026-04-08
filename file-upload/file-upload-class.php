<?php

echo "File Name " . $_FILES['myfile']['name'] . "<br>";
echo "File Temp Name " . $_FILES['filen']['tmp_name'] . "<br>";
echo "File Size " . $_FILES['filen']['size'] . "<br>";
echo " File Error " . $_FILES['filen']['error'] . "<br>";
echo "File Type " . $_FILES['filen']['type'] . "<br>";
echo "Full Path " . $_FILES['filen']['full_path'] . "<br>";

?>

<form action="" method="post" enctype="multipart/form-data">
<input type="img/png" name="filen">
<input type="submit" value="Upload">   
</form>