<?php

function rotLeft($a, $d) {
    $n = count($a);
    $rotated = array_slice($a, $d % $n);
    $rotated = array_merge($rotated, array_slice($a, 0, $d % $n));
    return implode("-", $rotated);
}


$a = array(1, 2, 3, 4, 5);
$d = 2;
$result = rotLeft($a, $d);
echo $result;