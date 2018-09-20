<?php
include_once "vendor/autoload.php";
use clases\ObjectFerreteria;
use clases\MultiCurl;
use clases\LoadUrls;

/*
* Configuración de php.ini
*/
set_time_limit(7200);
ini_set('default_charset', 'UTF-8');

/*
* Vector Inicial
*/
$vectorUrl        = array(0 => 'http://www.ecommercetemplate.net/');

/*
* Objeto inicial donde iremos guardando
* todos nuestros vectores
*/

/*
* Cogemos todos los content
* de todas las paginas ferreteria.es
*/
try {
$mc = new LoadUrls();
$mc->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
//$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
$mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
$mc->setTotal(count($vectorUrl));
$mc->setVectorUrls($vectorUrl);
//$mc->setFerreteria($ferreteriaObject);
$mc->setFuncion("setPrueba");
foreach($vectorUrl as $url){
$mc->addUrl($url);
}
$mc->wait();
} catch (Exception $e) {
die($e->getMessage());
}
?>