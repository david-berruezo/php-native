<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 27/01/2018
 * Time: 19:32
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
$cadena = 'text_title_image_1';
$valor  = substr($cadena,strlen($cadena)-1,1);
echo "la cadena es: ".$cadena." y el valor es: ".$valor."<br>";
?>