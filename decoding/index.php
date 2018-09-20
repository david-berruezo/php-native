<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 3/10/17
 * Time: 20:54
 */
include_once("vendor/autoload.php");
use clases\ObjetoDecodificarBase64;
use clases\ObjetoXml;
//$objeto = new ObjetoDecodificarBase64();
$objeto   = new ObjetoXml();
$objeto->leerXml();
//Sha1
$password = "Berruezin23";
echo "el password Berruezin23: ".sha1($password)."<br>";
$valor = sha1("2b6285748ed0e9c67920b721f21dd6073ca4d742");
echo $valor."<br>";
?>