<?php
include "class.php";

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $id = $_POST["id"];
    $address = $_POST["address"];

    $student = new Student($name, $id, $address);
    $student->saveToFile();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student System</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
        }

        .form-box {
            width: 350px;
            margin: 30px auto;
            border: 1px solid black;
            padding: 20px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .form-row label {
            width: 30%;
            text-align: left;
        }

        .form-row input {
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

<div class="form-box">
    <form method="post">

        <div class="form-row">
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-row">
            <label>ID:</label>
            <input type="text" name="id" required>
        </div>

        <div class="form-row">
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
    Student::showAllStudents();
    ?>
</table>

</body>
</html>