<?php
include_once "vendor/autoload.php";
use clases\ObjectFerreteria;
use clases\MultiCurl;
use clases\LoadUrls;
use clases\UrlsFerreteria;

/*
 * Configuración de php.ini
 */
set_time_limit(7200);
error_reporting(ERROR);
ini_set('default_charset', 'UTF-8');

/*
 * Vector Inicial
 */
//$vectorUrl        = array(0 => 'https://ferreteria.es');
//$vectorUrl          = array(0 => 'http://www.espaiclinic.es');
$vectorUrl        = array(0 => 'http://www.nemops.net/index.html');

/*
 * Objeto inicial donde iremos guardando
 * todos nuestros vectores
 */
$ferreteriaObject = new ObjectFerreteria();


/*
 * Cogemos todos los content
 * de todas las paginas ferreteria.es
 */
try {
    $mc = new UrlsFerreteria();
    $mc->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrl));
    $mc->setVectorUrls($vectorUrl);
    $mc->setFerreteria($ferreteriaObject);
    $mc->setFuncion("setIndexContent");
    foreach($vectorUrl as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}

/*
 * Ahora cogemos todos los
 * datos del vector Padre
 */

/*
$vectorUrlsPadres = $ferreteriaObject->getPadres();
try {
    $mc = new UrlsFerreteria();
    $mc->setMaxSessions(5); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrlsPadres));
    $mc->setVectorUrls($vectorUrlsPadres);
    $mc->setFerreteria($ferreteriaObject);
    $mc->setFuncion("setPadreContent");
    foreach($vectorUrlsPadres as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}
*/

/*
 * Ahora cogemos todos los hijos
 */

/*
$vectorUrlsHijos = $ferreteriaObject->getHijos();
try {
    $mc = new UrlsFerreteria();
    $mc->setMaxSessions(5); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrlsHijos));
    $mc->setVectorUrls($vectorUrlsHijos);
    $mc->setFerreteria($ferreteriaObject);
    $mc->setFuncion("setHijoContent");
    foreach($vectorUrlsHijos as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}
*/

/*
 * Ahora cogemos todos los nietos
 */

/*
$vectorUrlsNietos = $ferreteriaObject->getNietos();
try {
    $mc = new UrlsFerreteria();
    $mc->setMaxSessions(5); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrlsNietos));
    $mc->setVectorUrls($vectorUrlsNietos);
    $mc->setFerreteria($ferreteriaObject);
    $mc->setFuncion("setNietoContent");
    foreach($vectorUrlsNietos as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}
*/

/*
 * Ahora cogemos todos los productos
 */

/*
$vectorUrlProductos = $ferreteriaObject->getProducts();
try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(5); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $mc->setTotal(count($vectorUrlProductos));
    $mc->setVectorUrls($vectorUrlProductos);
    $mc->setFerreteria($ferreteriaObject);
    $mc->setFuncion("setProductoContent");
    foreach($vectorUrlProductos as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}
*/
?>