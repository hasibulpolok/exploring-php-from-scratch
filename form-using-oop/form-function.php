<!DOCTYPE html>
<html>
<head>
    <title>Store Data</title>
</head>
<body>
    <h2>Enter Data</h2>
    <form method="post">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <input type="submit" value="Save">
    </form>

    <?php

    if (!empty($_POST['id']) && !empty($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];

     
        $data = "ID: $id, Name: $name\n";

       
        file_put_contents("data.txt", $data, FILE_APPEND);

        echo "<p>Data saved successfully!</p>";
    }

   
    if (file_exists("data.txt")) {
        echo "<h3>All Entries:</h3><pre>" . file_get_contents("data.txt") . "</pre>";
    }
    ?>
</body>
</html>