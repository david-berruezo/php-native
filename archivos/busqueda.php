<?php
$vector = array(
    'http://www.ferreteria.net/sartenes/packs-especiales/packs-castey/pack-saludable-castey-yellow.html',
    'http://www.ferreteria.net/sartenes/sartenes-de-induccion/sarten-castey-induccion-26cm.htm'
);
foreach($vector as $url){
    $urlSinDominio = str_replace('http://www.ferreteria.net/'," ",$url);
    $urlSinDominio = rtrim(ltrim($urlSinDominio));
    $carpetas      = explode("/",$urlSinDominio);
    $ruta          = 'G:\urlproyectos\ferreteria.es\\';
    for ($i=0;$i<count($carpetas);$i++){
        $ruta.=$carpetas[$i].'\\';
    }
    $ruta = substr($ruta,0,strlen($ruta)-1);
    if (is_file($ruta)){
        echo "correcto el fichero existe: ".$ruta."<br>";
    }else{
        echo "incorrecto el fichero no existe: ".$ruta."<br>";
    }
}
?>