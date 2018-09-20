<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 19:23
 */


/*
 * The count_chars() function returns information about characters used in a string
 * (for example, how many times an ASCII character occurs in a string, or which characters that have been used or not been used in a string).
 */

/*
 * mode	Optional. Specifies the return modes. 0 is default. The different return modes are:
 * 0 - an array with the ASCII value as key and number of occurrences as value
 * 1 - an array with the ASCII value as key and number of occurrences as value, only lists occurrences greater than zero
 * 2 - an array with the ASCII value as key and number of occurrences as value, only lists occurrences equal to zero are listed
 * 3 - a string with all the different characters used
 * 4 - a string with all the unused characters
 */

$str = "Hello World!";
echo ($str.'<br>');
echo ('Modo 0:<br>');
//var_dump(count_chars($str,0));
echo ('Modo 1:<br>');
var_dump(count_chars($str,1));
echo ('Modo 2:<br>');
//var_dump(count_chars($str,2));
echo ('Modo 3:<br>');
//var_dump(count_chars($str,3));
echo ('Modo 4:<br>');
//var_dump(count_chars($str,4));

$vector = count_chars($str,1);
foreach($vector as $key=>$value){
    $caracter     = chr($key);
    //echo('Caracter: '.$caracter.'<br>');
    echo('Caracter 2: '.$key.'<br>');
    $vector[$key] = $caracter;
}
var_dump($vector);
