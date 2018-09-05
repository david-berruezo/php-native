<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 10:28
 */

// var
$arr = array(55,86,48,16,32);

function bubble_sort($arr) {
    $size = count($arr);
    for ($i=0; $i<$size; $i++) {
        for ($j=0; $j<$size-1-$i; $j++) {
            if ($arr[$j+1] < $arr[$j]) {
                swap($arr, $j, $j+1);
            }
        }
    }
    return $arr;
}

function swap(&$arr, $a, $b) {
    $tmp = $arr[$a];
    $arr[$a] = $arr[$b];
    $arr[$b] = $tmp;
}

function bubble_wikipedia_sort($arr) {
    $size = count($arr);
    for ($i=1; $i<$size; $i++) {
        for ($j=0; $j<$size-$i; $j++) {
            if ($arr[$j]> $arr[$j+1]  ) {
                //swap($arr, $j, $j+1);
                $aux       = $arr[$j];
                $arr[$j]   = $arr[$j+1];
                $arr[$j+1] = $aux;
            }
        }
    }
    return $arr;
}

// Llamamos a funciones
$vectorOrdenadoBubble    = bubble_sort($arr);
$vectorOrdenadoWikipedia = bubble_wikipedia_sort($arr);

echo ('El resultado de la primera ordenación es: ');
var_dump($vectorOrdenadoBubble);
echo ('<br>');
echo ('El resultado de la segunda ordenación es: ');
var_dump($vectorOrdenadoWikipedia);
echo ('<br>');