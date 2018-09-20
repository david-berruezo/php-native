<?php
$vector = array(
    'http://www.ferreteria.net/sartenes/packs-especiales/packs-castey/pack-saludable-castey-yellow.html',
    'http://www.ferreteria.net/sartenes/sartenes-de-induccion/sarten-castey-induccion-26cm.htm'
);
foreach($vector as $url){
    $urlSinDominio = str_replace('http://www.ferreteria.net/'," ",$url);
    $carpetas      = explode("/",$urlSinDominio);
    var_dump($carpetas);
}
?>