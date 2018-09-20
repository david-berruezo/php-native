<?php
include_once("MultiCurl.php");
/*
 * Cargamos urls
 */
class LoadUrls extends MultiCurl {
    private $funcion           = "";
    private $applicationObject = "";
    private $contador            = 0;
    private $total               = 0;
    private $contentVector       = array();

    protected function onLoad($url, $content, $info) {
        //print "[$url] $content ";
        //print_r($info);
        array_push($this->contentVector,$content);
        if ($this->contador >= $this->total - 1){
            echo "Finalizado<br>";
            $this->evaluateOptions();
        }
        $this->contador++;
    }
    private function evaluateOptions(){
        call_user_func_array(array($this->applicationObject,$this->funcion), array($this->contentVector));
    }
    public function setFuncion($funcion){
        $this->funcion = $funcion;
    }
    public function setApplicationObject($applicationObject){
        $this->applicationObject = $applicationObject;
    }
    public function setTotal($total){
        $this->total = $total;
    }
}
?>