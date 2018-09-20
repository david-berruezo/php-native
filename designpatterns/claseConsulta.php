<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 08/07/2016
 * Time: 8:10
 */

set_include_path("c:/htdocs/prueba/php/designpatterns");
include_once("claseSingleton.php");
//$instancia =  Singleton::getInstance();
$singleton   = new Singleton();
$singleton->conection();
$singleton->consulta1();