<form  method="post" enctype="multipart/form-data">

<input type="file" name="myfile">
<button type="submit">Upload</button>

</form>

<?php
print_r($_FILES);
?>

<?php 
echo $fileName = $_FILES['myfile']['name'];
echo $tempName= $_FILES['myfile']['tmp_name'];

move_uploaded_file($tempName, "uploads/". $fileName);

echo "File uploaded";
?>


