<?php
include "class.php";


if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $batch = $_POST["batch"];
    $result = $_POST["result"];

    $student = new Student($id, $name, $batch, $result);
    $student->saveToFile();
}


if (isset($_POST["search"])) {
    $searchId = $_POST["search_id"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result System</title>

    <style>
        body {
         
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

<h2>Student Entry Form</h2>

<div class="form-box">
    <form method="post">

        <div class="form-row">
            <label>ID:</label>
            <input type="text" name="id" required>
        </div>

        <div class="form-row">
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-row">
            <label>Batch:</label>
            <input type="text" name="batch" required>
        </div>

        <div class="form-row">
            <label>Result:</label>
            <input type="text" name="result" required>
        </div>

        <button name="submit">Save</button>

    </form>
</div>

<h2>Search Result</h2>

<div class="form-box">
    <form method="post">

        <div class="form-row">
            <label>Enter ID:</label>
            <input type="text" name="search_id" required>
        </div>

        <button name="search">Search</button>

    </form>
</div>

<div>
    <?php
    if (isset($searchId)) {
        Student::result($searchId);
    }
    ?>
</div>

<h2>All Students</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Batch</th>
        <th>Result</th>
    </tr>

    <?php

    if (file_exists("result.txt")) {
        $rows = file("result.txt");

        foreach ($rows as $row) {
            $data = explode(",", trim($row));
            echo "<tr>
                    <td>{$data[0]}</td>
                    <td>{$data[1]}</td>
                    <td>{$data[2]}</td>
                    <td>{$data[3]}</td>
                  </tr>";
        }
    }
    ?>
</table>

</body>
</html>