<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 25/11/17
 * Time: 12:15
 */

$variable;
$variable1 = "Hola";

if (isset($variable)){
    echo "variable creada<br>";
}else{
    echo "no existe<br>";
}


if (isset($variable1)){
    echo "variable creada<br>";
}else{
    echo "no existe<br>";
}

if (empty($variable)){
    echo "no tiene valor<br>";
}else{
    echo "variable con valor<br>";
}


if (empty($variable1)){
    echo "no tiene valor<br>";
}else{
    echo "variable con valor<br>";
}


if (!$variable){
    echo "no tiene valor<br>";
}else{
    echo "variable con valor<br>";
}


if (!$variable1){
    echo "no tiene valor<br>";
}else{
    echo "variable con valor<br>";
}


?>