<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:14
 */

/*
 * Convert a string from one character-set to another:
 * The supported Cyrillic character-sets are:
 * k - koi8-r
 * w - windows-1251
 * i - iso8859-5
 * a - x-cp866
 * d - x-cp866
 * m - x-mac-cyrillic
 */
$str = "Hello world! ���";
echo $str . "<br>";
echo convert_cyr_string($str,'w','a');

