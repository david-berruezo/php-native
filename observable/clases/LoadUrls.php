<?php
namespace clases;
use Application;
class LoadUrls extends MultiCurl {
    // var
    private $contador            = 0;
    private $total               = 0;
    private $contentVector       = array();
    private $vectorUrls          = array();
    private $application         = "";
    private $ObjectFerreteria    = "";
    private $funcion             = "";

    protected function onLoad($url, $content, $info) {
        array_push($this->contentVector, $content);
        if ($this->contador >= $this->total - 1){
            echo "Finalizado<br>";
            //$this->setCallApplication();
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

    public function setApplicationObject(Application $application){
        $this->application = $application;
    }

    public function setCallApplication(){
        $this->application->finalizarCarga($this->contentVector);
    }

    public function setIndexContent($vectorContent){
        $this->ObjectFerreteria->setIndexContent($vectorContent);
    }

    public function setPadreContent($vectorContent){
        $this->ObjectFerreteria->setPadreContent($vectorContent);
    }

    public function setHijoContent($vectorContent){
        $this->ObjectFerreteria->setHijoContent($vectorContent);
    }

    public function setNietoContent($vectorContent){
        $this->ObjectFerreteria->setNietoContent($vectorContent);
    }

    public function setProductoContent($vectorContent){
        $this->ObjectFerreteria->setProductoContent($vectorContent);
    }

    public function setFerreteria(ObjectFerreteria $ferreteriaObject){
        $this->ObjectFerreteria = $ferreteriaObject;
    }

    public function setFuncion($funcion){
        $this->funcion = $funcion;
    }
}
?>


