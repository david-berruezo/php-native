<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class ObjetoDiversual{

    public function __construct(){
        //libxml_use_internal_errors(false);
        //error_reporting(E_ERROR);
    }

    public function leerUrls($contenidoVector)
    {
        foreach ($contenidoVector as $contenido) {
            $this->consultaTituloFabricante($contenido);
            $this->consultaImagen($contenido);
            $this->consultaDescripcion($contenido);
        }
    }

    /*
     * Consultamos titulo y marca
     */
    public function consultaTituloFabricante($contenido){
        $dom             = new DOMDocument();
        @$dom->loadHTML("$contenido");
        $xpath           = new DOMXPath($dom);
        $tag             = "div";
        $class           = "primary_block row";
        $consulta        = "//".$tag."[@class='".$class."']";
        $elementos       = $xpath->query($consulta);
        if ($elementos->length > 0){
            $h1s = $elementos->item(0)->getElementsByTagName("h1");
            $h2s = $elementos->item(0)->getElementsByTagName("h2");
            if ($h1s->length > 0){
                echo "Nombre: ".$h1s->item(0)->nodeValue."<br>";
            }
            if ($h2s->length > 0){
                echo "Fabricante: ".$h2s->item(0)->nodeValue."<br>";
            }
        }
    }

    /*
     * Consultamos imagen
     */
    public function consultaImagen($contenido){
        $dom  = new DOMDocument();
        @$dom->loadHTML("$contenido");
        $div  = $dom->getElementById("image-block");
        $imgs = $div->getElementsByTagName("img");
        if ($imgs->length > 0){
            $img = $imgs->item(0);
            echo "imagen: ".$img->getAttribute("src")."<br>";
        }
    }

    /*
     * Consultamos descripcion
     */
    public function consultaDescripcion($contenido){
        $dom  = new DOMDocument();
        @$dom->loadHTML("$contenido");
        $div  = $dom->getElementById("short_description_content");
        echo "Desripción: ".$div->nodeValue."<br>";
    }


}
?>