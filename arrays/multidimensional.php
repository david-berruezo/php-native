<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 27/08/2016
 * Time: 9:40
 */
/*
array (size=4)
  3 =>
    array (size=5)
      0 =>
        array (size=24)
          0 =>
            array (size=11)
              0 => string ' Rosado' (length=7)
              1 => string ' Bodegas Marqués de Cáceres' (length=29)
              2 => string ' D.O.Ca. Rioja' (length=14)
              3 => string ' 4% Garnacha Tinta, 96% Tempranillo' (length=35)
              4 => string ' Fernando Gómez Sáez' (length=22)
              5 => string ' Familia Forner' (length=15)
              6 => string ' Bordelesa' (length=10)
              7 => string ' 75' (length=3)
              8 => string ' Servir a una temperatura de 8-9º C' (length=36)
              9 => string ' 01/2016' (length=8)
              10 => string ' Perfecto hasta mediados-finales de 2017' (length=40)
*/
$vector = array(
    0 => array(
        0 => array(
            0 => array(
                  0 => 'Rosado',
                  1 => 'Bodegas Marqués de Cáceres',
                  2 => 'D.O.Ca. Rioja',
                  3 => '4% Garnacha Tinta, 96% Tempranillo',
                  4 => 'Fernando Gómez Sáez',
                  5 => 'Familia Forner',
                  6 => 'Bordelesa',
                  7 => '75',
                  8 => 'Servir a una temperatura de 8-9º C',
                  9 => '01/2016',
                  10 => 'Perfecto hasta mediados-finales de 2017'
            )
        )
    )
);
var_dump($vector);
var_dump($vector[0][0][0]);

foreach($vector[0][0][0] as $keycarac => $carac){
    echo $keycarac. " ".$carac."<br>\n";
    /*
    foreach ($keycarac as $nombreCarac=>$valueCarac){
        //$caracteristicasString.= $caracteristicasNombre[$nombreCarac].$valorCarac. ",";
        echo $nombreCarac." ".$valueCarac;
    }
    */
}

?>