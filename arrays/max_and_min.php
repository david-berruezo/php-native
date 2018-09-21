<?php
$numbers = array(8,23,15,42,16,4);
print_r($numbers);
echo"<br>";
echo "Count: ".count($numbers)."<br>";
echo "Max: ".max($numbers)."<br>";
echo "Min: ".min($numbers)."<br>";
sort($numbers);
echo "Sort: ".print_r($numbers)."<br>";
rsort($numbers);
echo "Rverse Sort: ".print_r($numbers)."<br>";
$num_string = implode(" * ",$numbers);
echo "Strings numbers with implode: ".$num_string."<br>";
$num_array();
?>