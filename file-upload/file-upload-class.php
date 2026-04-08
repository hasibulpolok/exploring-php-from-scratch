
<form method="post" enctype="multipart/form-data">
    <input type="file" name="filen">
    <input type="submit" value="Upload">   
</form>

<?php
print_r($_FILES);
?>


<?php

echo "File Name " . $_FILES['myfile']['name'] . "<br>";
echo "File Temp Name " . $_FILES['filen']['tmp_name'] . "<br>";
echo "File Size " . $_FILES['filen']['size'] . "<br>";
echo " File Error " . $_FILES['filen']['error'] . "<br>";
echo "File Type " . $_FILES['filen']['type'] . "<br>";
echo  $_FILES['filen']['full_path'] . "<br>";

?>
