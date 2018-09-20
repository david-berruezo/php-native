<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class ObjectNemops {
    // Principal Vector
    private $categoriaPrincipal              = array();
    private $productos                       = array();
    // Content cUrl
    private $indexContent                    = array();
    private $padreContent                    = array();
    private $hijoContent                     = array();
    private $nietoContent                    = array();
    private $productoContent                 = array();
    // Urls padres,hijos,nietos
    private $vectorUrlsPadres                = array();
    private $vectorUrlsHijos                 = array();
    private $vectorUrlsNietos                = array();
    private $vectorUrlsHijosBuenos           = array();
    private $vectorUrlsHijosNietos           = array();
    private $vectorUrlHijosSinNietos         = array();
    private $vectorUrlsProductos             = array();
    // Texto Marca = key | Value  = Imagen Marcas
    private $vectorImagenesPrincipalesMarcas = array();
    // Caracteristicas Default
    private $vectorCaracteristicasDefault    = array();
    private $contador                        = 0;
    private $numeroPaginas                   = 0;

    /*
     * Constructor del objeto
     */
    public function __construct(){
        //libxml_use_internal_errors(true);
    }

    /*
     * Guardamos Pagination
     */
    public function setPagination($vectorContent){
        $this->indexContent  = $vectorContent;
        $cadena              = $this->scrapeIndex($this->indexContent);
        $this->numeroPaginas = $this->queryPagination($cadena[0]);
        $this->leerUrls($cadena[0]);
    }

    public function getPagination($vectorContent){
        return $this->numeroPaginas;
    }

    /*
     * Guardar Index Content
     */
    public function setIndexContent($vectorContent){
        $this->indexContent = $vectorContent;
        $cadena             = $this->scrapeIndex($this->indexContent);
        $this->leerUrls($cadena[0]);
    }

    /*
     * Cortamos el set Index Content
     */
    public function scrapeIndex($contenidoVector){
        $inicio        = '<div id="breadcrumbs">';
        $final         = '<div class="side-menu">';
        $cadena        = "";
        $vector        = array();
        foreach ($contenidoVector as $contenido){
            $cadenaContenido = ltrim(rtrim($contenido));
            $pos1 = stripos($cadenaContenido, $inicio);
            $pos2 = stripos($cadenaContenido, $final);
            if ($pos1 !== false) {
                //echo "Se encontró en la posición $pos1<br>";
            }
            if ($pos2 !== false) {
                //echo "Se encontró en la posición $pos2<br>";
            }
            $cadena = substr($cadenaContenido,$pos1,$pos2);
            array_push($vector,$cadena);
        }
        return $vector;
    }

    /*
     * Leemos todas las urls
     * Creamos Padres,Hijos,Nietos
     * y Cogemos imagenes de Index
     */
    public function leerUrls($contenidoVector){
        $dom               = new DOMDocument();
        $dom->loadHTML("$contenidoVector");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "posts-list";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elementos         = $xpath->query($consulta);
        if ($elementos->length > 0){
            foreach($elementos as $elemento){
                $vectorTituloUrl                                              = $this->queryTitulo($contenidoVector,$this->contador);
                $url                                                          = $vectorTituloUrl["href"];
                $titulo                                                       = $vectorTituloUrl["titulo"];
                $excerpt                                                      = $this->queryExerpt($contenidoVector,$this->contador);
                $imagen                                                       = $this->queryImage($contenidoVector,$this->contador);
                $chalendar                                                    = $this->queryChalendar($contenidoVector,$this->contador);
                $numComentarios                                               = $this->queryNumComentarios($contenidoVector,$this->contador);
                $this->categoriaPrincipal[$this->contador]                    = array();
                $this->categoriaPrincipal[$this->contador]["titulo"]          = $titulo;
                $this->categoriaPrincipal[$this->contador]["href"]            = $url;
                $this->categoriaPrincipal[$this->contador]["excerpt"]         = $excerpt;
                $this->categoriaPrincipal[$this->contador]["imagen"]          = $imagen;
                $this->categoriaPrincipal[$this->contador]["dia"]             = $chalendar["day"];
                $this->categoriaPrincipal[$this->contador]["mes"]             = $chalendar["month"];
                $this->categoriaPrincipal[$this->contador]["numComentarios"]  = $numComentarios;
                $this->contador++;
            }
        }
        var_dump($this->categoriaPrincipal);
    }



    /*
     * Convertir la url
     */
    public function convertirUrl($url){
        $urlConvertida = str_replace("https://ferreteria.es/","http://www.ferreteria.net/",$url);
        return $urlConvertida;
    }

    /*
     * Cogemos el numero de paginas
     */
    public function queryPagination($contenidoVector){
        $dom               = new DOMDocument();
        $dom->loadHTML("$contenidoVector");
        $xpath             = new DOMXPath($dom);
        $tag               = "a";
        $class             = "page-numbers";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elementos         = $xpath->query($consulta);
        $numero            = 0;
        foreach($elementos as $elemento){
            if ($elemento->nodeValue > $numero){
                $numero = $elemento->nodeValue;
            }
        }
        return $numero;
    }

    /*
     * Query Titulo
     */
    public function queryTitulo($content,$contadorTotal){
        $contador          = 0;
        $titulo            = array();
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "post-inner";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal) {
                    $div = $element;
                    $h2s = $div->getElementsByTagName("h2");
                    if ($h2s->length > 0) {
                        $h2 = $h2s->item(0);
                        $anchors = $h2->getElementsByTagName("a");
                        if ($anchors->length > 0) {
                            $anchor           = $anchors->item(0);
                            $titulo["titulo"] = $anchor->nodeValue;
                            $titulo["href"]   = $anchor->getAttribute("href");
                        }
                    }
                }
                $contador++;
            }
        }
        return $titulo;
    }

    /*
     * Query Excerpt
     */
    public function queryExerpt($content,$contadorTotal){
        $excerpt           = "";
        $contador          = 0;
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "p";
        $class             = "post-excerpt";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal){
                    $excerpt      = $element;
                    $excerptValue = rtrim(ltrim($excerpt->nodeValue));
                }
                $contador++;
            }
        }
        return $excerptValue;
    }

    /*
     * Query Chalendar
     */
    public function queryChalendar($content,$contadorTotal){
        $contador          = 0;
        $fecha             = array();
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "span";
        $class             = "day";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal ){
                    $span          = $element;
                    $fecha["day"]  = $span->nodeValue;
                    //echo "El dia es:".$fecha["day"]."<br>";
                }
                $contador++;
            }
        }
        $contador          = 0;
        $tag               = "span";
        $class             = "month";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal){
                    $span          = $element;
                    $fecha["month"]= $span->nodeValue;
                    //echo "El mes es:".$fecha["month"]."<br>";
                }
                $contador++;
            }
        }
        return $fecha;
    }

    /*
     * Query Chalendar
     */
    public function queryImage($content,$contadorTotal){
        $contador          = 0;
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "image";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal){
                    $div           = $element;
                    $imgs          = $div->getElementsByTagName("img");
                    if ($imgs->length > 0) {
                        $img    = $imgs->item(0);
                        $ruta   = $img->getAttribute("src");
                    }
                }
                $contador++;
            }
        }
        //echo "La imagen es: ".$ruta."<br>";
        return $ruta;
    }

    /*
     * Query Chalendar
     */
    public function queryNumComentarios($content,$contadorTotal){
        $contador          = 0;
        $numComentarios    = 0;
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "span";
        $class             = "comments";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal ){
                    $span         = $element;
                    $anchors      = $span->getElementsByTagName("a");
                    if ($anchors->length > 0) {
                        $anchor         = $anchors->item(0);
                        $numComentarios = $anchor->nodeValue;
                    }
                }
                $contador++;
            }
        }
        //echo "El numero de comentarios son: ".$numComentarios."<br>";
        return $numComentarios;
    }
}
?>