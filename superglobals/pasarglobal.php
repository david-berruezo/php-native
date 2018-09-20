<?php
namespace Proyecto\Superglobals;
/**
 * David Berruezo
 * User: David
 * Date: 29/07/2016
 * Time: 18:37
 */
echo ("Printeamos variables<br>\n");
echo ("El nombre es: " .$GLOBALS["nombre"]. " y el apellido es: " .$GLOBALS["apellido"] . "<br>\n");
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$uri = dirname($_SERVER['PHP_SELF']);
echo ("El directorio es: " .$uri. "<br>\n");
?>