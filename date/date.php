<!DOCTYPE html>
<html>
<head>
<title>PHP Date & Time Practice</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    padding:40px;
}

.container{
    width:700px;
    margin:auto;
}

.card{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0px 2px 10px rgba(0,0,0,0.1);
}

h2{
    margin-top:0;
    color:#333;
}

.result{
    color:#007bff;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="container">

<div class="card">
<h2>Current Date & Time</h2>

<?php
echo "<p class='result'>".date("Y-m-d")."</p>";
echo "<p class='result'>".date("Y-m-d H:i:s")."</p>";

echo "Today Date : <span class='result'>".date("d-m-Y")."</span><br>";
echo "Current Time : <span class='result'>".date("H:i:s")."</span>";

echo "<br><br>";
echo "<span class='result'>".date("d-m-Y H:i:s")."</span>";
?>
</div>


<div class="card">
<h2>Yesterday & Tomorrow</h2>

<?php
echo "Yesterday : <span class='result'>".date("Y-m-d", strtotime("-1 day"))."</span><br>";
echo "Tomorrow : <span class='result'>".date("Y-m-d", strtotime("+1 day"))."</span>";
?>

</div>


<div class="card">
<h2>Age Calculator</h2>

<?php
$birth = "1997-11-25";
$age = date("Y") - date("Y", strtotime($birth));

echo "Age : <span class='result'>".$age."</span>";
?>

</div>


<div class="card">
<h2>Days Between Two Dates</h2>

<?php
$date1 = "2026-03-01";
$date2 = "2026-03-11";

$diff = strtotime($date2) - strtotime($date1);
$days = $diff / (60*60*24);

echo "Total Days : <span class='result'>".$days."</span>";
?>

</div>


<div class="card">
<h2>Account Expire Check</h2>

<?php
$expire = "2026-03-20";
$today = date("Y-m-d");

if($today > $expire){
    echo "<span style='color:red;font-weight:bold;'>Account Expired</span>";
}else{
    echo "<span style='color:green;font-weight:bold;'>Account Active</span>";
}
?>

</div>


<div class="card">
<h2>Event Countdown</h2>

<?php
$event = "2026-04-01";

$diff = strtotime($event) - time();
$days = floor($diff / (60*60*24));

echo "Days Left : <span class='result'>".$days."</span>";
?>

</div>


<div class="card">
<h2>Facebook Style Time</h2>

<?php
$time = strtotime("2026-03-11 10:00:00");
$now = time();

$diff = $now - $time;

$minutes = floor($diff / 60);

echo "<span class='result'>".$minutes." minutes ago</span>";
?>

</div>


<div class="card">
<h2>Timezone</h2>

<?php

echo "Default Timezone : <span class='result'>".date_default_timezone_get()."</span><br>";

date_default_timezone_set("Asia/Dhaka");

echo "Dhaka Time : <span class='result'>".date('h:i:s A')."</span>";

?>

</div>

</div>

</body>
</html>