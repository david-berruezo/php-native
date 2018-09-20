<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:03
 */

/*
 * Return characters from different ASCII values:
 * The ASCII value can be specified in decimal, octal, or hex values. Octal values are defined by a leading 0,
 * while hex values are defined by a leading 0x.
 */
echo chr(52) . "<br>"; // Decimal value
echo chr(052) . "<br>"; // Octal value
echo chr(0x52) . "<br>"; // Hex value

$str = chr(046);
echo("You $str me forever!<br>");

$str  = chr(43);
$str2 = chr(61);
echo("2 $str 2 $str2 4");