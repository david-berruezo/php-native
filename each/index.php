<?php
/*
 * Recorrer una array associativa
 * each sin clave
 */
$vector = array(
    "nombre"   => "David",
    "apellido" => "Berruezo"
);
var_dump($vector);
echo("<br>");
echo ("Recorremos una array con un each sin la clave solo valor<br>\n");
foreach($vector as $elemento){
    echo ("El elemento es: " .$elemento. "<br>\n");
}
echo("<br>");
echo ("Recorremos una array con un each con la clave y valor<br>\n");
foreach($vector as $key=>$elemento){
    echo ("Clave es: " .$key. "<br>\n");
    echo ("Elemento es: " .$elemento. "<br>\n");
    echo("<br>");
}
echo("<br>");

/*
 * Recorrer una array no associativ de strings
 * each sin clave
 */
echo("<br><br>\n");
$vector = array("David","Antonio","Loli","Andreu","Elvira");
var_dump($vector);
echo("<br>");
echo ("Recorremos una array con un each sin la clave solo valor<br>\n");
foreach($vector as $elemento){
    echo ("El elemento es: " .$elemento. "<br>\n");
}
echo("<br>");
echo ("Recorremos una array con un each con la clave y valor<br>\n");
foreach($vector as $key=>$elemento){
    echo ("Clave es: " .$key. "<br>\n");
    echo ("Elemento es: " .$elemento. "<br>\n");
    echo("<br>");
}
echo("<br>");

/*
 * Recorrer una array no associativa de numeros
 * each sin clave
 */
echo("<br><br>\n");
$vector = array(1,2,3,4,5);
var_dump($vector);
echo("<br>");
echo ("Recorremos una array con un each sin la clave solo valor<br>\n");
foreach($vector as $elemento){
    echo ("El elemento es: " .$elemento. "<br>\n");
}
echo("<br>");
echo ("Recorremos una array con un each con la clave y valor<br>\n");
foreach($vector as $key=>$elemento){
    echo ("Clave es: " .$key. "<br>\n");
    echo ("Elemento es: " .$elemento. "<br>\n");
    echo("<br>");
}
echo("<br>");

/*
 * Modificamos los elementos de la array
 * por referencia y dentro del bucle each
 */
echo("<br><br><br>\n");
$array = array(1, 2, 3, 4);
foreach ($array as &$valor) {
    $valor = $valor * 2;
}
// $array ahora es array(2, 4, 6, 8)
echo ("El valor de la array es: <br>\n");
var_dump($array);
echo("<br>");
echo ("El valor del último elemento del array es: " .$valor. "<br>\n");
unset($valor);
echo ("El valor de la array es: <br>\n");
var_dump($array);
echo ("El valor del último elemento del array es: " .$valor. "<br>\n");
echo("<br><br><br>\n");

/*
 * Otro ejemplo
 */
$array = array(1, 2, 3, 4);
var_dump($array);
echo("<br>");
foreach ($array as &$valor) {
    $valor = $valor * 2;
}
//unset($valor);
// $array ahora es array(2, 4, 6, 8)
// sin unset($valor), $valor aún es una referencia al último elemento: $array[3]
foreach ($array as $clave => $valor) {
    // $array[3] se actualizará con cada valor de $array...
    echo ("---------- Vez {$clave} ----------<br>\n");
    echo "{$clave} => {$valor} ";
    echo("<br>");
    print_r($array);
    echo ("---------- Fin ----------<br>\n");
    echo("<br>");

}
// ...hasta que finalmente el penúltimo valor se copia al último valor
// salida:
// 0 => 2 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 2 )
// 1 => 4 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 4 )
// 2 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )
// 3 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )

?>