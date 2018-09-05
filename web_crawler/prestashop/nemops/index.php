<?php
include_once "vendor/autoload.php";
use clases\LoadUrls;
use clases\ObjectNemops;
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
$loadUrls     = new LoadUrls();
$objetoNemops = new ObjectNemops();
$application  = new Application($objetoNemops);

class Application {
    private $objectNemops;
    /*
     * Cargamos el index
     */
    public function __construct($objectNemops)
    {
        $this->objectNemops = $objectNemops;
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setPaginador");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->addUrl('http://www.nemops.net/');
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public static function callIt(callable $func) {
        //call_user_func($func);
    }
    public function setPaginador($contentVector){
        $this->objectNemops->setPagination($contentVector);
        $this->getIndexContent();
    }
    public function getIndexContent(){
        $numeroPaginas = $this->objectNemops->getPagination();
        $vectorUrl     = array();
        for ($i = 0; $i < $numeroPaginas; $i++){
            $page = $i + 2;
            $url  = "http://www.nemops.net/page/".$page."/";
            array_push($vectorUrl,$url);
        }
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(count($vectorUrl));
            foreach($vectorUrl as $url){
                $loadUrls->addUrl($url);
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setIndexContent($contentVector){
        $this->objectNemops->setIndexContent($contentVector);
        $this->objectNemops->getCategoriaPrincipal();
        $this->getPadresContent();
    }

    public function getPadresContent(){
        $vectorUrl = $this->objectNemops->getUrlDetalle();
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setPadreContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            //$loadUrls->setTotal(count($vectorUrl));
            $contador = 0;
            foreach($vectorUrl as $url){
                //if ($contador == 0){
                    $loadUrls->addUrl($url);
                //}
                $contador++;
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setPadreContent($contentVector){
        $this->objectNemops->setPadreContent($contentVector);
    }
}
?>