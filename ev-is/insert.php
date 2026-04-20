<form method="POST" action="">
    Name: <input type="text" name="name"><br>
    country: <input type="text" name="country"><br>
 
    <input type="submit" name="submit" value="Save">
</form>

<?php
$conn = new mysqli("localhost", "root", "", "shop_bd");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $country = $_POST['country'];
    

    $sql = "CALL manufracture_name('$name', '$country')";
    
    if($conn->query($sql)){
        echo "Inserted Successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>