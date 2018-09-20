<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:18
 */

/*
 * Decode a string and then decode it:
 */
$str = ",2&5L;&\@=V]R;&0A `";
echo convert_uudecode($str);
echo('<br>');

/*
 * Encode a string and then decode it:
 */
$str = "Hello world!";
// Encode the string
$encodeString = convert_uuencode($str);
echo $encodeString . "<br>";
echo('<br>');

// Decode the string
$decodeString = convert_uudecode($encodeString);
echo $decodeString;
echo('<br>');
