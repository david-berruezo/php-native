<?php
namespace clases;
use Application;
class LoadUrls extends MultiCurl {
    private $contador            = 0;
    private $total               = 0;
    private $contentVector       = array();
    private $vectorUrls          = array();
    private $funcion             = "";
    private $ferreteriaObject    = "";
    private $empezado            = false;
    protected function onLoad($url, $content, $info) {
        array_push($this->contentVector, $content);
        $this->contador++;
        $this->evaluateOptions();
    }

    public function evaluateOptions(){
        if ($this->contador == $this->total){
            echo "Finalizado<br>";
            call_user_func(array($this,$this->funcion ), $this->contentVector);
        }
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

    public function setFerreteria($ferreteriaObject){
        $this->ferreteriaObject = $ferreteriaObject;
    }

    public function setIndexContent(){
        $this->ferreteriaObject->setIndexContent($this->contentVector);
    }
    public function setPadreContent(){
        $this->ferreteriaObject->setPadreContent($this->contentVector);
    }
    public function setHijoContent(){
        $this->ferreteriaObject->setHijoContent($this->contentVector);
    }
    public function setNietoContent(){
        $this->ferreteriaObject->setNietoContent($this->contentVector);
    }
}
?>


