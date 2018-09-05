<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 11:19
 */

// var
$array = array(55,86,48,16,32);
for($j=1; $j < count($array); $j++){
    $temp = $array[$j];
    $i = $j;
    while(($i >= 1) && ($array[$i-1] > $temp)){
        $array[$i] = $array[$i-1];
        echo ('1.- Intercambio: '.$array[$i].'<br>');
        echo ('2.- Puntero i: '.$i.'<br>');
        $i--;
    }
    $array[$i] = $temp;
    echo ('3.- Array de posicion: '.$array[$i].'<br>');
    echo ('4.- Puntero :: '.$j.'<br>');
    var_dump($array);
    echo ('<br>');
}

echo ('El resultado de la primera ordenación es: ');
var_dump($array);
echo ('<br>');

$array = array(5,2,4,6,1,3);
var_dump($array);
echo ('<br>');
$inicio = FALSE;
for ($j=1;$j<count($array);$j++){
    $clave = $array[$j];
    $i     = $j - 1;
    echo ('j: '.$j.' i: '.$i.' clave: '.$clave.'<br>');
    while ($i >0 && $array[$i] > $clave || $inicio == FALSE ){
        echo ('array[$i+1]: '.$array[$i+1].'array[$i]: '.$array[$i].'<br>');
        $array[$i+1] = $array[$i];
        echo ('array[$i+1]: '.$array[$i+1].'array[$i]: '.$array[$i].'<br>');
        $i = $i - 1;
        echo ('i: '.$i.'<br>');
        $array[$i+1] = $clave;
        echo ('array[$i]: '.$array[$i].'<br>');
        $inicio = TRUE;
    }

}

echo ('El resultado de la segunda ordenación es: ');
var_dump($array);
echo ('<br>');