<!DOCTYPE html>
<html>

<head>
    <title>OOP User Form</title>
    <style>
        .form-container {
            width: 300px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-group label {
            width: 80px;
          
        }

        .form-group input {
            flex: 1;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>User Information Form</h2>
    <form method="POST" class="form-container">
        <div class="form-group">
            <label>ID:</label>
            <input type="text" name="id" required>
        </div>

        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" required>
        </div>

        <div class="form-group">
            <label>Contact:</label>
            <input type="text" name="contact" required>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php

    class User
    {
        public $id;
        public $name;
        public $address;
        public $contact;

        public function __construct($name, $id, $address, $contact)
        {
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->contact = $contact;
        }

        public function display()
        {
            echo "<h3>Submitted Data:</h3>";
            echo "ID: " . htmlspecialchars($this->id) . "<br>";
            echo "Name: " . htmlspecialchars($this->name) . "<br>";
            echo "Address: " . htmlspecialchars($this->address) . "<br>";
            echo "Contact: " . htmlspecialchars($this->contact) . "<br>";
        }

        public function saveToFile()
        {
            $data = $this->id . "|" . $this->name . "|" . $this->address . "|" . $this->contact . "\n";
            file_put_contents("users.txt", $data, FILE_APPEND);
        }
    }

    // Handle form submission
    if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $id = htmlspecialchars($_POST['id']);
        $address = htmlspecialchars($_POST['address']);
        $contact = htmlspecialchars($_POST['contact']);

        $user = new User($name, $id, $address, $contact);
        $user->saveToFile();
        $user->display();
    }

    // Function to display all saved users safely
    function displaySavedUsers()
    {
        $file = "users.txt";

        if (file_exists($file) && filesize($file) > 0) {
            echo "<h3>All Saved Users:</h3>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th></tr>";

            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $parts = explode("|", $line);
                if (count($parts) === 4) {  // Only process valid lines
                    list($id, $name, $address, $contact) = $parts;
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($id) . "</td>";
                    echo "<td>" . htmlspecialchars($name) . "</td>";
                    echo "<td>" . htmlspecialchars($address) . "</td>";
                    echo "<td>" . htmlspecialchars($contact) . "</td>";
                    echo "</tr>";
                }
            }

            echo "</table>";
        } else {
            echo "<h3>No saved users yet.</h3>";
        }
    }

    // Display all saved users
    displaySavedUsers();


    ?>



</body>

</html>