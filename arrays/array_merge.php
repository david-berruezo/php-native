<?php
/**
 * Ejemplo 1
 * No hay array merge
 */
$default_server_values = array(
    'SERVER_SOFTWARE' => '',
    //'REQUEST_URI' => '',
);

echo ('********************** Datos de server ********************<br>');
while(list($key,$value) = each($_SERVER)){
    echo('Key: '.$key.' Value: '.$value.'<br>');
}
echo ('***********************************************************<br>');
echo('phpself: '.$_SERVER['PHP_SELF'].'<br>');
$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
echo('phpself: '.$_SERVER['PHP_SELF'].'<br>');
var_dump($_SERVER);


/*
 * Ejemplo 2
 *
 */
$vectorUno = array("puta" => "69");
$vectorDos = array("marca" => "Nike", "modelo" => "Air");
$resultado = array_merge($vectorUno,$vectorDos);
var_dump($resultado);

$valor = array(
    0 => array(
        0 => 'https://ferreteria.es/media/catalog/category/packs-especiales_2.jpg'
    ),
);

echo "valor: ".$valor[0][0]."<br>";