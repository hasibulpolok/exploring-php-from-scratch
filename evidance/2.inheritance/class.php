<?php

class Person
{
    public $id;
    public $name;
    public $batch;

    function __construct($id, $name, $batch)
    {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }
}

class Student extends Person
{
    public $result;

    function __construct($id, $name, $batch, $result)
    {
        parent::__construct($id, $name, $batch);
        $this->result = $result;
    }


    function saveToFile()
    {
        $line = $this->id . "," . $this->name . "," . $this->batch . "," . $this->result . "\n";
        file_put_contents("result.txt", $line, FILE_APPEND);
    }

    public static function result($searchId)
    {
        if (file_exists("result.txt")) {
            $rows = file("result.txt");

            foreach ($rows as $rowData) {
                $data = explode(",", ($rowData));

                if ($data[0] == $searchId) {
                    echo "ID: " . $data[0] . "<br>";
                    echo "Name: " . $data[1] . "<br>";
                    echo "Batch: " . $data[2] . "<br>";
                    echo "Result: " . $data[3] . "<br>";
                    return;
                }
            }

            echo "Record not found!";
        } else {
            echo "File not found!";
        }
    }
}

?>