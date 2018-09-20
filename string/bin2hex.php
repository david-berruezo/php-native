<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 18:56
 */

// Convierte un string ascii a hexadecimal
$str = bin2hex("Hello World!");
echo($str);

// Convert a string value from binary to hex and back:
$str = "Hello world!";
echo bin2hex($str) . "<br>";
echo pack("H*",bin2hex($str)) . "<br>";