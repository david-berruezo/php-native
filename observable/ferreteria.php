<?php
require_once ("vendor\autoload.php");
use clases\MultiCurl;
use clases\LoadUrls;
use clases\ObjectFerreteria;
use clases\Observer;

//$aplication = new Application();


$ferreteriaObject = new ObjectFerreteria();
$vectorUrl       = array(0 => 'http://www.ferreteria.net/index.html');

/*
 * Cogemos todos los content
 * de todas las paginas ferreteria.es
 */
try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
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
$vectorUrlsPadres = $ferreteriaObject->getPadres();
try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
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


/*
 * Ahora cogemos todos los hijos
 */


$vectorUrlsHijos = $ferreteriaObject->getHijos();
try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
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


/*
 * Ahora cogemos todos los nietos
 */
$vectorUrlsNietos = $ferreteriaObject->getNietos();
try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
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


class Application{
    // Objects
    private $ferreteriaObject;
    private $urlsFerreteria;
    // var
    private $vectorUrl;
    private $funcion = "setIndexContent";

    public function __construct()
    {
        $this->ferreteriaObject = new ObjectFerreteria();
        $this->vectorUrl        = array(0 => 'http://www.ferreteria.net/index.html');
        ini_set('default_charset', 'UTF-8');
        $this->loadUrls();
    }


    public function cargarPadreHijoNieto(){
        $funcion = "setIndexContent";
        for ($i=0;$i<3;$i++){
            try {
                $mc = new LoadUrls();
                $mc->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
                //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
                $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                $mc->setTotal(count($this->vectorUrl));
                $mc->setVectorUrls($this->vectorUrl);
                $mc->setFerreteria($this->ferreteriaObject);
                $mc->setFuncion("setIndexContent");
                foreach($this->vectorUrl as $url){
                    $mc->addUrl($url);
                }
                $mc->wait();
            } catch (Exception $e) {
                die($e->getMessage());
            }
            switch($i){
                case 0:$vectorUrlsPadres = $ferreteriaObject->getPadres();
                break;
                case 1:$vectorUrlsPadres = $ferreteriaObject->getPadres();
                break;
                case 2:$vectorUrlsPadres = $ferreteriaObject->getPadres();
                break;
                case 3:$vectorUrlsPadres = $ferreteriaObject->getPadres();
                break;
            }
        }
    }


    /*
     * Cuando finaliza de
     * cargar las urls
     */
    public function finalizarCarga($vectorContent){
        if ($this->funcion != "productos") {
            $this->setContentObjectFerreteria($vectorContent);
            $this->getContentObjectFerreteria();
            $this->loadUrls();
            $this->finalizarCategorias = TRUE;
        }else{
            $this->comprobarProductos();
            //$this->loadUrls();
            echo "FINALIZADO<BR>";
            //var_dump($vectorContent);
        }
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
            case "setNietoContent":$this->ferreteriaObject->setProductoContent($vectorContent);
                break;

        }
        echo "funcion set: ".$this->funcion."<br>";
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
                $this->vectorUrl = $this->ferreteriaObject->getHijos();
                $this->funcion   = "setHijoContent";
                break;
            case "setHijoContent":
                $this->vectorUrl = $this->ferreteriaObject->getNietos();
                $this->funcion   = "setNietoContent";
                break;
            case "setNietoContent":
                $this->vectorUrl = $this->comprobarProductos($this->ferreteriaObject->getProducts());
                $this->funcion   = "setProductoContent";
                break;
            /*
            case "productos":
                //$this->vectorUrl = $this->comprobarProductos($this->ferreteriaObject->getProducts());
                //$this->funcion   = "productos";
                break;
            */
        }
        echo "funcion get: ".$this->funcion."<br>";
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
            $this->urlsFerreteria->setApplicationObject($this);
            foreach($this->vectorUrl as $url){
                $this->urlsFerreteria->addUrl($url);
            }
            $this->urlsFerreteria->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }



    public function comprobarProductos(){
        $vectorUrlProductos           = $this->ferreteriaObject->getProducts();
        var_dump($vectorUrlProductos);
        $vectorUrlProductosExistentes = array();
        $contador                     = 0;
        foreach($vectorUrlProductos as $url){
            $urlSinDominio = str_replace('http://www.ferreteria.net/'," ",$url);
            $urlSinDominio = rtrim(ltrim($urlSinDominio));
            $carpetas      = explode("/",$urlSinDominio);
            $ruta          = 'G:\urlproyectos\ferreteria.es\\';
            for ($i=0;$i<count($carpetas);$i++){
                $ruta.=$carpetas[$i].'\\';
            }
            $ruta = substr($ruta,0,strlen($ruta)-1);
            if (is_file($ruta)){
                array_push($vectorUrlProductosExistentes,$url);
                $contador++;
            }
        }
        $this->vectorUrl = $vectorUrlProductosExistentes;
        var_dump($this->vectorUrl);
    }

    public function crearProductos($puntero){
        global $vectorUrlProductosExistentes;
        global $ferreteriaObject;
        $vectorUrls1000   = array();
        $contadorProducto = 0;
        foreach($vectorUrlProductosExistentes as $url) {
            if ($contadorProducto >= $puntero * 1000 && $contadorProducto < ($puntero+1) * 1000 ) {
                array_push($vectorUrls1000,$url);
            }
            $contadorProducto++;
        }
        try {
            $mc = new UrlsFerreteria();
            $mc->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $mc->setMaxSize(10240);
            $mc->setTotal(1000);
            $mc->setVectorUrls($vectorUrls1000);
            $mc->setFerreteria($ferreteriaObject);
            $mc->setContadorProductos($puntero);
            //$mc->setFuncion("setProductoContent");
            foreach($vectorUrls1000 as $url){
                $mc->addUrl($url);
            }
            $mc->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>