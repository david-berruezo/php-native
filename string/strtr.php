<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/06/2016
 * Time: 15:36
 */
// strtr — Convierte caracteres o reemplaza substrings
// strtr == str transform
$cadena1 = "Curso de PHP - en este curso de PHP aprenderemos a programar en php";
$cadena2 = strtr( $cadena1, "CeP", "Dép" );
echo $cadena2;  // Devuelve: "Durso dé pHp - én ésté curso dé pHp apréndérémos a programar én php"
?>