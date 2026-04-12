<?php

class Person
{
    public $name;
    public $address;

    function __construct($name, $address)
    {
        $this->name = $name;
        $this->address = $address;
    }
}

class Student extends Person
{
    public $studentId;

    function __construct($name, $studentId, $address)
    {
        parent::__construct($name, $address);
        $this->studentId = $studentId;
    }

 
    function saveToFile()
    {
        $line = $this->name . "," . $this->studentId . "," . $this->address . "\n";
        file_put_contents("user.txt", $line, FILE_APPEND);
    }

  
    static function showAllStudents()
    {
        if (file_exists("user.txt")) {
            $rows = file("user.txt");

            foreach ($rows as $rowData) {
                $data = explode(",", trim($rowData));

                echo "<tr>
                        <td>{$data[0]}</td>
                        <td>{$data[1]}</td>
                        <td>{$data[2]}</td>
                      </tr>";
            }
        }
    }
}

?>