<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 02/08/2016
 * Time: 18:59
 */

/*
 * Probamos sentencia Die();
 * para finalizar la aplicación
 */

$a         = 5;
$b         = 3;
$opcion    = "multiplicar";
$resultado = 0;

// LLamada funciones
$resultado = sumar($a,$b);
resultado("suma");
$resultado = restar($a,$b);
resultado("resta");
$resultado = multiplicar($a,$b);
resultado("multiplicación");
die();
$resultado = dividir($a,$b);
resultado("división");
function sumar($a,$b){
    return $a + $b;
}
function restar($a,$b){
    return $a - $b;
}
function multiplicar($a,$b){
    return $a * $b;
}
function dividir($a,$b){
    return $a/$b;
}
function resultado($operacion){
    global $a,$b, $resultado;
    echo ("El valor de a es: ".$a. " y de b es: ".$b." y el resultado de la operación ".$operacion." es: ".$resultado."<br>\n");
}
?>