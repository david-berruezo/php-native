<?php
$keys      = ['madrid', 'paris', 'roma'];
$values    = ['españa', 'francia', 'italia'];
// Combine
$paises    = array_combine($keys,$values);
// Values
$capitales = array_keys($keys);
$paises    = array_values($values);
list($capital1,$capital2,$capital3) = $keys;
// Multidimensional
$arrays = [[1, 2], [3, 4], [5, 6]];
foreach ($arrays as list($a, $b)) {
    $c = $a + $b;
    echo($c . ', '); // 3, 7, 11,
}

$string = 'hello|wild|world';
list($hello, , $world) = explode('|', $string);
echo("$hello, $world"); // hello, world

$array = [
    'clothes' => 't-shirt',
    'size'    => 'medium',
    'color'   => 'blue',
];

extract($array);
echo("$clothes $size $color"); // t-shirt medium blue

$clothes = 't-shirt';
$size    = 'medium';
$color   = 'blue';

$array = compact('clothes','size', 'color');
print_r($array);

// Array
// (
//     [clothes] => t-shirt
//     [size] => medium
//     [color] => blue
// )
?>