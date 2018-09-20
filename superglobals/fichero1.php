<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 11:07
 */

/*
 * Icluimos dos ficheros,
 * Uno lo incluimos desde fuera de una función
 * y el otro desde dentro de una función
 */
function ficheroDesdeFuncion() {
    include "fichero3.php";
}
ficheroDesdeFuncion();
include "fichero2.php";
?>