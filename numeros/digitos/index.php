<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 1/10/17
 * Time: 11:10
 */
$numero  = 1.1234;
$numero2 = 1234.8;
$numero3 = 1234;
$numero_format_number  = number_format($numero, 2, '.', '');
$numero2_format_number = number_format($numero2, 2, '.', '');
$numero3_format_number = number_format($numero3, 2, '.', '');
echo "el numero 1 es: ".$numero_format_number."<br>";
echo "el numero 2 es: ".$numero2_format_number."<br>";
echo "el numero 3 es: ".$numero3_format_number."<br>";
?>