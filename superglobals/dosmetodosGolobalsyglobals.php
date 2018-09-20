<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 07/07/2016
 * Time: 8:10
 */

/*
 * Primer método utilizando la función global
 * detro de la función
 */
$a = 1;
$b = 2;
function Suma()
{
    global $a, $b;
    $b = $a + $b;
}
Suma();
echo $b;

/*
 * Utilizando el vector GLOBALS que es
 * un array asociativo que contiene todas
 * las variables
 */
$a = 1;
$b = 2;
function SumaGlobals()
{
    $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
}
SumaGlobals();
echo $b;

$parametro = 0;

/*
 * Las superglobales estan disponibles
 * desde todas partes también desde
 * dentro de la función
 */
function test_global()
{
    // La mayoría de variables predefinidas no son "super" y requieren
    // 'global' para estar disponibles al ámbito local de las funciones.
    //global $HTTP_POST_VARS;
    //global $_GET;
    //echo $HTTP_POST_VARS['name'];
    echo('El parametro desde dentro es: '.$_GET['parametro'].'<br>');
    // Las superglobales están disponibles en cualquier ámbito y no
    // requieren 'global'. Las superglobales están disponibles desde
    // PHP 4.1.0, y ahora HTTP_POST_VARS se considera obsoleta.
    //echo $_POST['name'];
}
test_global();
echo('El parametro desde fuera es: '.$_GET['parametro'].'<br>');
