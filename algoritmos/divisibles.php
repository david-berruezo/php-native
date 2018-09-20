<?php
/**
 * Ejerccio de números primos.
 * User: david
 * Date: 12/04/18
 * Time: 12:03
 */

// Número primo     == Número divisible entre EL y entre 1
// Número no primo  == Divisible por más de un número.


# Show errors
//error_reporting(E_ALL);
//error_reporting(-1);
//ini_set('display_errors',1);

# Not sow errors
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);


# Start the program
$num1       = "5";
$num2       = "200";
$divisibles = 0;
$resultados = array();
$numero_seleccionado = 0;
$i = $num1;
for($i >= $num1; $i <= $num2; $i++){
    $divisibles = 0;
    $numero_seleccionado = $i;
    $j = $numero_seleccionado;
    for($j <= $numero_seleccionado;$j>=1;$j--){
        if ($numero_seleccionado % $j == 0  ){
            $divisibles++;
            $iCadena = (string)$i;
            if (is_array($resultados[$iCadena])) array_push($resultados[$iCadena],$j); else $resultados[$iCadena]=array(); array_push($resultados[$iCadena],$j);
        }
    }
    if ($divisibles == 2) echo "El numero $numero_seleccionado tiene $divisibles divisibles y es primo<br>"; else echo "El numero $numero_seleccionado tiene $divisibles divisibles y no es primo<br>";
}
echo "<br><br>";
echo "Los números divisibles son:<br>";
foreach($resultados as $numero=>$numero_divisibles){
    echo "El número $numero es divisible por los siguientes números: <br>";
    print_r($numero_divisibles);
    echo "<br><br>";
}
echo "<br><br>";
?>