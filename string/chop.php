<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 18:59
 */

// Remove characters from the right end of a string:
$str = "Hello World!";
echo $str . "<br>";
echo chop($str,"World!");
echo("<br>");
echo chop($str,"d!");