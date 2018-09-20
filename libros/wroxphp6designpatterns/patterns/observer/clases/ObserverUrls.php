<?php
namespace clases;
class ObserverUrls{
    // var
    private $vectorUrl;
    private $ferreteriaObject;
    private $urlsFerreteria;
    private $funcion = "setIndexContent";

    public function update(){
        echo "Actualizado";
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
    public function finalizarCarga($funcion,$vectorContent){
        echo "Hola";
        /*
        self::setFuncion($funcion);
        self::setContentObjectFerreteria($vectorContent);
        self::getContentObjectFerreteria();
        self::loadUrls();
        call_user_func(array('self','llamarFunciones'), null);
        */
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
            $this->urlsFerreteria = new UrlsFerreteria();
            $this->urlsFerreteria->setMaxSessions(10); // limit 2 parallel sessions (by default 10)
            $this->urlsFerreteria->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $this->urlsFerreteria->setTotal(count($this->vectorUrl));
            $this->urlsFerreteria->setVectorUrls($this->vectorUrl);
            //$this->urlsFerreteria->setFerreteria($this->ferreteriaObject);
            $this->urlsFerreteria->setFuncion($this);
            $this->urlsFerreteria->setFuncion($this->funcion);
            foreach($this->vectorUrl as $url){
                $this->urlsFerreteria->addUrl($url);
            }
            $this->urlsFerreteria->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    /*
     * Ahora cogemos todos los
     * datos del vector Padre
     */
    public function loadUrlsPadres(){
        echo "getPadres:<br>";
        $this->vectorUrl = $this->ferreteriaObject->getPadres();
        try {
            $this->urlsFerreteria = new UrlsFerreteria();
            $this->urlsFerreteriasetMaxSessions(2); // limit 2 parallel sessions (by default 10)
            //$mc->setMaxSize(1073741824); // limit 10 Kb per session (by default 10 Mb)
            $this->urlsFerreteriasetMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $this->urlsFerreteriasetTotal(count($this->vectorUrl));
            $this->urlsFerreteriasetVectorUrls($this->vectorUrl);
            $this->urlsFerreteriasetFerreteria($this->ferreteriaObject);
            $this->urlsFerreteriasetFuncion("setPadreContent");
            foreach($this->vectorUrl as $url){
                $this->urlsFerreteriaaddUrl($url);
            }
            $this->urlsFerreteriawait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }




    public function comprobarProductos(){
        $vectorUrlProductos           = $this->ferreteriaObject->getProducts();
        $vectorUrlProductosExistentes = array();
        $vectorUrls1000               = array();
        $contador                     = 0;
        $contadorVueltas              = 0;
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
        $contador = 0;

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