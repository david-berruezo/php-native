<?php
/**
 * Division con resto
 * User: David
 * Date: 24/10/2016
 * Time: 12:38
 */

/*
$n = 1.25;
$whole = floor($n);      // 1
$fraction = $n - $whole; // .25
*/

$numero       = 38790;
$divisor      = $numero / 1000;
$dec          = NumberBreakdown($divisor,false);
$resto        = $dec[1] * 1000;
echo "Parte entera es: ".$dec[0]."<br>";
echo "Parte decimal es: ".$dec[1]."<br>";
echo "Resto decimal es: ".$resto."<br>";
var_dump($dec);

function NumberBreakdown($number, $returnUnsigned = false)
{
    $negative = 1;
    if ($number < 0)
    {
        $negative = -1;
        $number *= -1;
    }

    if ($returnUnsigned){
        return array(
            floor($number),
            ($number - floor($number))
        );
    }

    return array(
        floor($number) * $negative,
        ($number - floor($number)) * $negative
    );
}

?>