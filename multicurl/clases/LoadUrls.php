<?php
namespace clases;
use Application;
class LoadUrls extends MultiCurl {
    private $contador            = 0;
    private $total               = 0;
    private $contentVector       = array();
    private $vectorUrls          = array();
    private $funcion             = "";

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
}
?>


