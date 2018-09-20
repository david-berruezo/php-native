<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 18:00
 */

class Clientecorreo{

    private $nombre;
    private $version;
}

$vector = array(
    'Numeros' => array(
        1,2,3,4,5
    )
);

$vector2 = array(
    'Numeros' => array(
        6,7,8,9,10
    )
);

$nuevoVector = array_change_key_case($vector,CASE_UPPER);
var_dump($vector);
echo('<br>');
var_dump($nuevoVector);
echo('<br>');

$otroVector = array_chunk($nuevoVector['NUMEROS'],2);
echo('<br>');
var_dump($otroVector);
echo('<br>');

$vectorCombinado = array_combine($vector['Numeros'],$vector2['Numeros']);
var_dump($vectorCombinado);

$vectorDiferencia = array_diff_assoc($vector['Numeros'],$vector2['Numeros']);
echo('<br>');
var_dump($vectorDiferencia);
echo('<br>');

