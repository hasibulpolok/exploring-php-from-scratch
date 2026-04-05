<?php


require_once("userone.php");
require_once("user2.php");
require_once("user3.php");

use Userone\User as user1;
use UserTwo\User as user2;
use user\User3 as user3;

$result = new user1();
$result2 = new user2();
$result3 = new user3();

$result->userInfo();
$result2->userInfo();
$result3->userInfo();


?>