<form action="upload" method="post" enctype=""multipart/form-data">

<input type="file" name="myfile">
<button type="submit"></button>

</form>


<?php 
$fileName = $_FILES['myfile']['name'];
$tempNamec= $_FILES['myfile']['tmp_name'];

move_uploaded_file($tempNamec, "uploads/$fileName");

echo "File uploaded";
?>
