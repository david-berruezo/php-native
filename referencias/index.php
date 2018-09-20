<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 07/07/2016
 * Time: 7:59
 */

/*
 * Paso por referencia
 */
$nombre   = "David";
$apellido = "Berruezo";
function foo(&$var)
{
    $var =& $GLOBALS["nombre"];
}
echo("variable nombre: " .$nombre . "<br>");
echo("variable apellido: " .$apellido . "<br>");
foo($apellido);
echo("variable nombre: " .$nombre . "<br>");
echo("variable apellido: " .$apellido . "<br>");

