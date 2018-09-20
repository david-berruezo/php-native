<?php
include_once("vendor\autoload.php");
use clases\MultiCurl;
use clases\LoadUrls;
use clases\ObjectFerreteria;
$application = new Application();

class Application extends MultiCurl{
    // var
    private $vectorUrl;
    private $ferreteriaObject;
    private $urlsFerreteria;
    private $funcion = "setIndexContent";

    protected function onLoad($url, $content, $info) {
        array_push($this->contentVector, $content);
        if ($this->contador >= $this->total - 1){
            echo "Finalizado<br>";
            $this->evaluateOptions();
        }
        $this->contador++;
    }

    /*
     * Construimos nuestro objeto
     */
    public function __construct()
    {
        $this->ferreteriaObject = new ObjectFerreteria();
        $this->vectorUrl        = array(0 => 'http://www.ferreteria.net/index.html');
        ini_set('default_charset', 'UTF-8');
        $this->loadUrls();
    }

    /*
     * Cuando finaliza de
     * cargar las urls
     */
    public static function finalizarCarga($vectorContent){
        echo "Hola";
        //$this->setFuncion($funcion);
        //$this->setContentObjectFerreteria($vectorContent);
        //$this->getContentObjectFerreteria();
        //$this->loadUrls();
        //call_user_func(array('self','llamarFunciones'), null);

    }

    /*
     * Llenamos object ferreteria
     */
    public function setContentObjectFerreteria($vectorContent){
        switch($this->funcion){
            case "setIndexContent":$this->ferreteriaObject->setIndexContent($vectorContent);
                break;
            case "setPadreContent":$this->ferreteriaObject->setPadreContent($vectorContent);
                break;
            case "setHijoContent":$this->ferreteriaObject->setHijoContent($vectorContent);
                break;
            case "setNietoContent":$this->ferreteriaObject->setNietoContent($vectorContent);
                break;
        }
    }

    /*
     * Llenar vector
     */
    public function getContentObjectFerreteria(){
        switch($this->funcion){
            case "setIndexContent":
                $this->vectorUrl = $this->ferreteriaObject->getPadres();
                $this->funcion   = "setPadreContent";
                break;
            case "setPadreContent":
                $this->ferreteriaObject->getHijos();
                $this->funcion   = "setHijoContent";
                break;
            case "setHijoContent":
                $this->ferreteriaObject->getNietos();
                $this->funcion   = "setNietoContent";
                break;
            //case "setNietoContent":$this->ferreteriaObject->setNietoContent($vectorContent);
            //break;
        }
        /*
        switch ($this->funcion){
            case "padres": $this->vectorUrl = $this->ferreteriaObject->getPadres();
            break;
            case "hijos":$this->vectorUrl  = $this->ferreteriaObject->getHijos();
            break;
            case "nietos":$this->vectorUrl = $this->ferreteriaObject->getNietos();
            break;
        }
        */
    }

    /*
     * Cogemos todos los content
     * de todas las paginas ferreteria.es
     */
    public function loadUrls(){

        try {
            $this->urlsFerreteria = new LoadUrls();
            $this->urlsFerreteria->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
            $this->urlsFerreteria->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $this->urlsFerreteria->setTotal(count($this->vectorUrl));
            $this->urlsFerreteria->setVectorUrls($this->vectorUrl);
            $this->urlsFerreteria->setObject($this);
            $this->urlsFerreteria->setFuncion($this->funcion);
            foreach($this->vectorUrl as $url){
                $this->urlsFerreteria->addUrl($url);
            }
            $this->urlsFerreteria->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>