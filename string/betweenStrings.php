<?php
error_reporting(E_ERROR);
include_once("LoadUrls.php");
$application = new Application();
$application->leerDirectorios();
$application->getUrl();

class Application{
    private $vectorDirectorios = array();
    public function leerDirectorios(){
        $directorio = "G:\urlproyectos\wpbeginner.com\wp-tutorials";
        $ficheros   = scandir($directorio);
        $contador   = 0;
        foreach ($ficheros as $fichero){
            $temp = (string)$fichero;
            if ($contador == 0 xor $contador == 1 xor $temp == "index.html"){
                //echo "No nos interesa<br>";
            }else{
                array_push($this->vectorDirectorios,$fichero);
            }
            $contador++;
        }
    }

    public function getUrl()
    {
        $contador    = 0;
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(1);
            foreach($this->vectorDirectorios as $fichero){
                if ($contador == 0){
                    $loadUrls->addUrl('http://www.wpbeginner.es/wp-tutorials/'.$fichero);
                }
                $contador++;
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setIndexContent($vectorContent){
        foreach($vectorContent as $content){
            $cadena = rtrim(ltrim($content));
            $dom   = new DomDocument();
            $dom->loadHTML($cadena);
            $xpath = new DOMXPath($dom);
            $tag   = "div";
            $consulta = "//div[contains(@class, 'post-')]";
            $nodeList = $xpath->query($consulta);
            $item              = $nodeList->item(0);
            var_dump($item->nodeValue);
            //$htmlString        = $dom->saveHTML($item->nodeValue);
            //var_dump($htmlString);
        }
    }
}
?>