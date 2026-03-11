<?php
echo date("Y-m-d");
?>

<?php
echo "<br>";
echo date("Y-m-d H:i:s");
echo "<br>";


echo "Today Date : ".date("d-m-Y");
echo "<br>";
echo "Current Time : ".date("H:i:s");
echo "<br>";echo "<br>";
// date_default_timezone_set("Asia/Dhaka");

echo date("d-m-Y H:i:s");
echo "<br>";
// yesterday 
echo "yesterday time";
echo date("Y-m-d", strtotime(" -1 day"));
echo "<br>";
//tomorrow
echo "tomorrow date";
echo date("y-m-d",strtotime(" +1 day") ) ;
echo "<br>";
echo "<br>";
echo "age calculator";
echo "<br>";
$birth = "1997-11-25";

$age = date("Y") - date("Y", strtotime($birth));

echo "Age : ".$age;


// time between 
echo "<br>";
echo "<br>";

$date1 = "2026-03-01";
$date2 = "2026-03-11";

$diff = strtotime($date2) - strtotime($date1);

$days = $diff / (60*60*24);

echo "Total Days : ".$days;


// expire check 
echo "<br>";
$expire = "2026-03-20";
$today = date("Y-m-d");

if($today > $expire){
    echo "Account Expired";
}else{
    echo "Account Active";
}

// countdown 

echo "<br>";


$event = "2026-04-01";

$diff = strtotime($event) - time();

$days = floor($diff / (60*60*24));

echo "Days Left : ".$days;

echo "<br>";

echo "facebook style time ";
echo "<br>";

$time = strtotime("2026-03-11 10:00:00");
$now = time();

$diff = $now - $time;

$minutes = floor($diff / 60);

echo $minutes." minutes ago";

echo date_default_timezone_get().date('h:i');
echo date_default_timezone_set("asia/dhaka").date('h:i');
echo date_default_timezone_get().date('h:i');



?>