<?php
$numbers = [
    "01712345678",
    "01898765432",
    "0123456789",
    "019123456789",
    "01712345abc"
];

$pattern = "/^01[3-9][0-9]{8}$/";

foreach ($numbers as $num) {
    echo $num . " → " . (preg_match_all($pattern, $num) ? "Valid ✅" : "Invalid ❌") . "\n";
}
?>
