<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 01/07/2016
 * Time: 11:13
 */

/*
 * Rompe un string en diferentes partes y
 * devueve un array y recordemos si el
 * limite = -1 todos -1
 * limite = n = n
 * Sin limite = todo
 */

$string = "Mi mama me mima";
$vector = explode(' ',$string,-1);
var_dump($vector);
echo('<br>');
$vector = explode(' ',$string,4);
var_dump($vector);

echo('<br>');
$vector = explode(' ',$string);
var_dump($vector);


