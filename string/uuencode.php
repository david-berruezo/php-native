<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:21
 */
$str = "Hello world!";
echo convert_uuencode($str);

$str = "Hello world!";
// Encode the string
$encodeString = convert_uuencode($str);
echo $encodeString . "<br>";

// Decode the string
$decodeString = convert_uudecode($encodeString);
echo $decodeString;

