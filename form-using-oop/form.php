<!DOCTYPE html>
<html>
<head>
    <title>OOP Form</title>
</head>
<body>

<h2>User Information Form</h2>

<form method="POST">
    
    ID: <input type="text" name="id"><br><br>
    Name: <input type="text" name="name"><br><br>
    Address: <input type="text" name="address"><br><br>
    Contact: <input type="text" name="contact"><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php

class User {
    public $name;
    public $id;
    public $address;
    public $contact;


    public function __construct($name, $id, $address, $contact) {
        $this->id = $id;
         $this->name = $name;
        $this->address = $address;
        $this->contact = $contact;
    }

  
    public function display() {
        echo "<h3>Submitted Data:</h3>";
        echo "Name: " . $this->name . "<br>";
        echo "ID: " . $this->id . "<br>";
        echo "Address: " . $this->address . "<br>";
        echo "Contact: " . $this->contact . "<br>";
    }
}


if (isset($_POST['submit'])) {
    $user = new User(
        $_POST['name'],
        $_POST['id'],
        $_POST['address'],
        $_POST['contact']
    );

    $user->display();
}

?>

</body>
</html>