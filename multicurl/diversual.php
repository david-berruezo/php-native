<?php
include_once "vendor/autoload.php";
// Librerias van cambiando segun la pagina web
use clases\ObjetoDiversual;
use clases\UrlsDiversual;
// Librerias siempre las mismas
use clases\MultiCurl;
use clases\LoadUrls;


/*
 * Configuración de php.ini
 */
ini_set('default_charset', 'UTF-8');
//ini_set("memory_limit",-1);

$vectorUrl        = array(0 => 'http://www.diversual.com/es/91323-we-vibe-4-plus-lila-solo-control-remoto-desde-el-movil.html');

/*
 * Objeto inicial donde iremos guardando
 * todos nuestros vectores
 */
$diversualObject = new ObjetoDiversual();

/*
 * Cogemos todos los content
 * de todas las paginas ferreteria.es
 */
try {
    $mc = new UrlsDiversual();
    $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrl));
    $mc->setVectorUrls($vectorUrl);
    $mc->setObject($diversualObject);
    $mc->setFuncion("setLeerUrls");
    foreach($vectorUrl as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}

?>