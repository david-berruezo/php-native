<?php
include_once "vendor/autoload.php";
use clases\LoadUrls;
use clases\ObjectWpbeginner;
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
$objetoNemops = new ObjectWpbeginner();
$application  = new Application($objetoNemops);

class Application {
    private $objectWpbeginner;
    /*
     * Cargamos el index
     */
    public function __construct($objectWpbeginner)
    {
        $this->objectWpbeginner = $objectWpbeginner;
        $this->objectWpbeginner->leerDirectorios();
        $directorios = $this->objectWpbeginner->getDirectorios();
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(count($directorios));
            foreach($directorios as $fichero){
                $loadUrls->addUrl('http://www.wpbeginner.es/wp-tutorials/'.$fichero);
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function setIndexContent($contentVector){
        $this->objectWpbeginner->setIndexContent($contentVector);
        //$categorias = $this->objectWpbeginner->getCategoriaPrincipal();
        //var_dump($categorias);
    }
}
?>