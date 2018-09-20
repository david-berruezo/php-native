<?php
include_once "vendor/autoload.php";
use clases\LoadUrls;
use clases\UrlsEmexs;
use clases\MultiCurl;

/*
 * Errores
 */
//ini_set('display_errors', 'On');
error_reporting(E_ERROR);
//ini_set('display_errors', '1');

/*
 * Cargamos objetos
 */
$loadUrls        = new LoadUrls();
$objetoUrlsEmexs = new UrlsEmexs();
$application     = new Application($objetoUrlsEmexs);

class Application {
    private $objetoEmexs;
    /*
     * Cargamos el index
     */
    public function __construct($objetoEmexs)
    {
        echo "entra<br>";
        $this->objetoEmexs = $objetoEmexs;
        $urls = $this->objetoEmexs->getUrls();
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setResult");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(count($urls));
            foreach($urls as $url){
                $loadUrls->addUrl($url);
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setResult($contentInfo){
        $this->objetoEmexs->setInfo($contentInfo);
        $this->objetoEmexs->sendEmail();
    }
}
?>
