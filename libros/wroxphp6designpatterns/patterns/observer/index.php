<?php
require_once("vendor/autoload.php");
// Ejemplo 1
use clases\CD;
use clases\BuyCDNotifyStreamObserver;
use clases\ActivityStream;
// Ejemeplo 2
use clases\LoadUrls;
use clases\MultiCurl;
use clases\UrlsFerreteria;
use clases\ObserverUrls;
use clases\ObjectFerreteria;

/*
 * Ejemplo 1
 */
$title    = "Waste of a Rib";
$band     = "Never Again";
$cd       = new CD($title, $band);
$observer = new BuyCDNotifyStreamObserver();
$cd->attachObserver("purchased", $observer);
$cd->buy();


/*
 * Ejemplo 2
 */

/*
$vectorUrl        = array(0 => 'http://www.ferreteria.net/index.html');
$observer         = new ObserverUrls();

/*
try {
    $urlsFerreteria = new UrlsFerreteria();
    $urlsFerreteria->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
    $urlsFerreteria->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $urlsFerreteria->setTotal(count($vectorUrl));
    $urlsFerreteria->setVectorUrls($vectorUrl);
    //$this->urlsFerreteria->setFerreteria($this->ferreteriaObject);
    //$urlsFerreteria->setFuncion($this);
    $urlsFerreteria->setFuncion("setIndexContent");
    $urlsFerreteria->attachObserver("finalizar",$observer);
    foreach($vectorUrl as $url){
        $urlsFerreteria->addUrl($url);
    }
    $urlsFerreteria->wait();
} catch (Exception $e) {
    die($e->getMessage());
}
*/
?>