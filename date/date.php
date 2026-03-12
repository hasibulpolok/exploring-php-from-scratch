<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Ultimate PHP Date Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
font-family: 'Segoe UI',sans-serif;
color:white;
min-height:100vh;
}

.dashboard-title{
text-align:center;
margin-bottom:40px;
font-weight:600;
}

.card{
background: rgba(255,255,255,0.08);
border:none;
border-radius:16px;
padding:25px;
backdrop-filter: blur(12px);
transition:0.3s;
height:100%;
}

.card:hover{
transform: translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.card h5{
color:#dfefff;
margin-bottom:15px;
}

.value{
font-size:26px;
font-weight:600;
color:#00eaff;
}

.clock{
font-size:38px;
font-weight:bold;
letter-spacing:2px;
}

@media(max-width:768px){

.clock{
font-size:28px;
}

.value{
font-size:22px;
}

}

</style>

</head>

<body>

<div class="container py-5">

<h2 class="dashboard-title">PHP Smart Date Dashboard</h2>

<div class="row g-4">

<!-- Live Clock -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Live Clock</h5>
<div id="clock" class="clock"></div>

</div>
</div>

<!-- Today Date -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Today Date</h5>
<div class="value">
<?php echo date("l, d M Y"); ?>
</div>

</div>
</div>

<!-- Timezone -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Timezone</h5>

<div class="value">

<?php
date_default_timezone_set("Asia/Dhaka");
echo date_default_timezone_get();
?>

</div>

</div>
</div>

<!-- Age -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Age</h5>

<div class="value">

<?php



$birth = new DateTime("1997-11-25");
$today = new DateTime();

$age = $today->diff($birth);

echo "Age : ".$age->y." Years ".$age->m." Months ".$age->d." Days";



?>

</div>

</div>
</div>

<!-- Yesterday -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Yesterday</h5>

<div class="value">
<?php echo date("Y-m-d",strtotime("-1 day")); ?>
</div>

</div>
</div>

<!-- Tomorrow -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Tomorrow</h5>

<div class="value">
<?php echo date("Y-m-d",strtotime("+1 day")); ?>
</div>

</div>
</div>

<!-- Days Between -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Days Between</h5>

<div class="value">

<?php

$date1="2026-03-01";
$date2="2026-03-11";

$diff=strtotime($date2)-strtotime($date1);

$days=$diff/(60*60*24);

echo $days." Days";

?>

</div>

</div>
</div>

<!-- Account Status -->
<div class="col-lg-3 col-md-6">
<div class="card text-center">

<h5>Account Status</h5>

<div class="value">

<?php

$expire="2026-03-20";
$today=date("Y-m-d");

if($today>$expire){

echo "<span class='text-danger'>Expired</span>";

}else{

echo "<span class='text-success'>Active</span>";

}

?>

</div>

</div>
</div>

<!-- Countdown -->
<div class="col-lg-6 col-md-12">
<div class="card text-center">

<h5>Event Countdown</h5>

<div id="countdown" class="value"></div>

</div>
</div>

<!-- Facebook Style Time -->
<div class="col-lg-6 col-md-12">
<div class="card text-center">

<h5>Facebook Style Time</h5>

<div class="value">

<?php

$time=strtotime("2026-03-11 10:00:00");
$now=time();

$diff=$now-$time;

$minutes=floor($diff/60);

echo $minutes." minutes ago";

?>

</div>

</div>
</div>

</div>

</div>

<script>

function updateClock(){

let now=new Date();

let h=now.getHours();
let m=now.getMinutes();
let s=now.getSeconds();

if(m<10)m="0"+m;
if(s<10)s="0"+s;

document.getElementById("clock").innerHTML=h+":"+m+":"+s;

}

setInterval(updateClock,1000);
updateClock();


let eventDate=new Date("2026-04-01").getTime();

let x=setInterval(function(){

let now=new Date().getTime();

let diff=eventDate-now;

let days=Math.floor(diff/(1000*60*60*24));
let hours=Math.floor((diff%(1000*60*60*24))/(1000*60*60));
let minutes=Math.floor((diff%(1000*60*60))/(1000*60));
let seconds=Math.floor((diff%(1000*60))/1000);

document.getElementById("countdown").innerHTML=

days+"d "+hours+"h "+minutes+"m "+seconds+"s";

},1000);

</script>

</body>
</html>