<?php
namespace clases;
use Application;
class LoadUrls extends MultiCurl {
    private $contador            = 0;
    private $total               = 0;
    private $contentVector       = array();
    private $vectorUrls          = array();
    private $funcion             = "";
    private $objeto              = "";

    protected function onLoad($url, $content, $info) {
        array_push($this->contentVector, $content);
        if ($this->contador >= $this->total - 1){
            echo "Finalizado<br>";
            $this->evaluateOptions();
        }
        $this->contador++;
    }
    public function evaluateOptions(){
        call_user_func(array($this,$this->funcion ), $this->contentVector);
    }
    public function setTotal($total){
        $this->total = $total;
    }

    public function setVectorUrls($vectorUrls){
        $this->vectorUrls = $vectorUrls;
    }

    public function setFuncion($funcion){
        $this->funcion = $funcion;
    }

    public function setIndexContent(){
        //$this->objeto->finalizarCarga($this->contentVector);
        //$objeto = $this->objeto;
        //call_user_func(array($objeto,'finalizarCarga' ), $this->contentVector);
        Application::finalizarCarga($this->contentVector);
    }

    public function setPadreContent(){
        //$this->ObjectFerreteria->setPadreContent($vectorContent);
        Application::finalizarCarga($this->contentVector);
    }

    public function setHijoContent(){
        //$this->ObjectFerreteria->setHijoContent($vectorContent);
        Application::finalizarCarga($this->contentVector);
    }

    public function setNietoContent(){
        //$this->ObjectFerreteria->setNietoContent($vectorContent);
        Application::finalizarCarga($this->contentVector);
    }

    public function setObject(Application $object){
        $this->object = $object;
    }

}
?>


