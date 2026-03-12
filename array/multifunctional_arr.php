<?php

$marry = array (
    array (3,6,4,2),
    array(6,8,7,3),
    array(3,6,4,2)
);

echo "<h3>Marry Array</h3>";

for($i = 0; $i < count($marry); $i++){

    echo "<ul>";
    echo "<b>Row ".($i+1)."</b>";

    for($j = 0; $j < count($marry[$i]); $j++){
        echo "<li>".$marry[$i][$j]."</li>";
    }

    echo "</ul>";
}

echo "<br>";

$arr = [
["A","t","r","r","w"],
["A","t","r","r","w"],
[3,5,2,1,7],
];

echo "<h3>Arr Array</h3>";

for($i = 0; $i < count($arr); $i++){

    echo "<ul>";
    echo "<b>Row ".($i+1)."</b>";

    for($j = 0; $j < count($arr[$i]); $j++){
        echo "<li>".$arr[$i][$j]."</li>";
    }

    echo "</ul>";
}

?>