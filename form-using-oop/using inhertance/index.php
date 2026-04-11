<?php
include "class.php";


if (isset($_POST["submit"])) {
    $s = new Student($_POST["name"], $_POST["id"], $_POST["address"]);
    $s->format();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple System</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
        }

        .form-container {
            width: 350px;
            margin: 30px auto;
            border: 1px solid black;
            padding: 20px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .form-group label {
            width: 30%;
            text-align: left;
        }

        .form-group input {
            width: 65%;
            padding: 5px;
        }

        button {
            margin-top: 15px;
            padding: 8px 20px;
        }

        table {
            margin: 30px auto;
            width: 70%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>

<h2>Student Form</h2>

<div class="form-container">
<form method="post">

    <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>

    <div class="form-group">
        <label>ID:</label>
        <input type="text" name="id" required>
    </div>

    <div class="form-group">
        <label>Address:</label>
        <input type="text" name="address" required>
    </div>

    <button name="submit">Save</button>

</form>
</div>

<table>
<tr>
    <th>Name</th>
    <th>ID</th>
    <th>Address</th>
</tr>

<?php 

Student::display();
?>

</table>

</body>
</html>