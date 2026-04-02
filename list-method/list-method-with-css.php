<?php
$person = [
    [1, 'Md Hasibul Bashar Polok', 27, 'hasibulpolok.bdn@gmail.com', '01765967395', 'Dhaka'],
    [2, 'Sanjida', 22, 'pakhia232@gmail.com', '01303272466', 'Dhaka'],
    [3, 'Saurav Hossain', 26, 'saurav@gmail.com', '01823456789', 'Gazipur'],
    [4, 'Mustafijur Rahman', 25, 'mustafijur@gmail.com', '01934567890', 'Khulna'],
    [5, 'Tanvir Ahmed', 28, 'tanvir@gmail.com', '01645678901', 'Chittagong'],
    [6, 'Nusrat Jahan', 24, 'nusrat@gmail.com', '01556789012', 'Rajshahi'],
    [7, 'Rakib Hasan', 29, 'rakib@gmail.com', '01367890123', 'Sylhet'],
    [8, 'Farhana Akter', 23, 'farhana@gmail.com', '01778901234', 'Barisal'],
    [9, 'Imran Khan', 30, 'imran@gmail.com', '01889012345', 'Comilla'],
    [10, 'Jannat Ara', 22, 'jannat@gmail.com', '01990123456', 'Rangpur'],
    [11, 'Shakib Al Hasan', 35, 'shakib@gmail.com', '01601234567', 'Magura']
];
?>
<style>

.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}


.card {
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
    background-color: #fff;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 2px 5px 15px rgba(0,0,0,0.2);
}

.card strong {
    display: inline-block;
    width: 70px;
}
</style>

<div class="grid-container">
<?php
foreach ($person as list($id, $name, $age, $email, $phone, $city)) {
    echo "<div class='card'>
            <p><strong>ID:</strong> $id</p>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Age:</strong> $age</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>City:</strong> $city</p>
          </div>";
}
?>
</div>