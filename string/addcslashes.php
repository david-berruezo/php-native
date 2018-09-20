<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 18:22
 */

/*
 * Agega la barra delante del caracter W
 * Note: Be careful using addcslashes() on 0 (NULL), r (carriage return), n (newline), f (form feed), t (tab)
 * and v (vertical tab). In PHP, \0, \r, \n, \t, \f and \v are predefined escape sequences.
 */
$str = addcslashes("Hello World!","W");
echo($str);

$str = "Welcome to my humble Homepage!";
echo $str."<br>";
echo addcslashes($str,'m')."<br>";
echo addcslashes($str,'H')."<br>";

$str = "Welcome to my humble Homepage!";
echo $str."<br>";
echo addcslashes($str,'A..Z')."<br>";
echo addcslashes($str,'a..z')."<br>";
echo addcslashes($str,'a..g');

?>