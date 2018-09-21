<?php
$content   = array();
$productos = array();
$resto     = array();
for ($i=0;$i<20500;$i++){
   $producto           = array();
   $producto["id"]     = $i;
   $producto["nombre"] = "Producto ".$i;
   array_push($content,"contenido".$i);
   array_push($productos,$producto);
}
//var_dump($content);
//var_dump($productos);
//$porcion  = count($productos) / 20;
//$fraction = count($productos) - ($porcion * 20); // .25
for ($i=0;$i<20;$i++){
    $output = array_slice($productos,$i*1000, 1000);
    mostrarMil($output);
}
mostrarResto($productos);
function mostrarMil($productos){
    var_dump($productos);
}
function mostrarResto($productos){
    global $resto;
    for ($i=1000*20;$i<count($productos);$i++){
        array_push($resto,$productos[$i]);
    }
}
var_dump($resto);

/*
$input = array("a", "b", "c", "d", "e");
$len = count($input);
$firsthalf = array_slice($input, 0, $len / 2);
$secondhalf = array_slice($input, $len / 2);
*/
?>