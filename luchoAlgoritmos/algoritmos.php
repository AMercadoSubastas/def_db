<?php

// Given an array of integers your solution should find the smallest integer.

// For example:

// Given [34, 15, 88, 2] your solution will return 2
// Given [34, -345, -1, 100] your solution will return -345
// You can assume, for the purpose of this kata, that the supplied array will not be empty.

// FUNDAMENTALS


$array = [34, 15, 88, 100];
$count = count($array);

for ($i=0; $i < $count ; $i++) {

    $bucle = $array[$i];
    echo "bucle: $bucle\n";
    
    for ($e = $count - 1; $e > 0; $e--) {  // Cambia $e >= 0 y $e = $count a $e = $count - 1
        $bucle2 = $array[$e];
        echo "Valor de \$bucle2: $bucle2\n";
    }
    
}

if ($bucle < $bucle2) {
    echo "Este resultado es el mas chico es $bucle";
} else {
    exit;
}
