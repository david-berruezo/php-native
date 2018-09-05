<?php
namespace clases;
use DOMDocument;
use DOMXPath;
use DateTime;
class ObjectNemops {
    // Principal Vector
    private $categoriaPrincipal              = array();
    private $vectorDetalleContent            = array();
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
        $vectorCadena       = $this->scrapeIndex($this->indexContent);
        foreach($vectorCadena as $content){
            $this->leerUrls($content);
        }
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
        $contador          = 0;
        if ($elementos->length > 0){
            foreach($elementos as $elemento){
                $vectorTituloUrl                                              = $this->queryTitulo($contenidoVector,$contador);
                $url                                                          = $this->convertirUrl($vectorTituloUrl["href"]);
                array_push($this->vectorUrlsPadres,$url);
                $titulo                                                       = $vectorTituloUrl["titulo"];
                $excerpt                                                      = $this->queryExerpt($contenidoVector,$contador);
                $imagen                                                       = $this->queryImage($contenidoVector,$contador);
                $chalendar                                                    = $this->queryChalendar($contenidoVector,$contador);
                $numComentarios                                               = $this->queryNumComentarios($contenidoVector,$contador);
                $this->categoriaPrincipal[$this->contador]                    = array();
                $this->categoriaPrincipal[$this->contador]["titulo"]          = $titulo;
                $this->categoriaPrincipal[$this->contador]["href"]            = $url;
                $this->categoriaPrincipal[$this->contador]["excerpt"]         = $excerpt;
                $this->categoriaPrincipal[$this->contador]["imagen"]          = $imagen;
                $this->categoriaPrincipal[$this->contador]["dia"]             = $chalendar["day"];
                $this->categoriaPrincipal[$this->contador]["mes"]             = $chalendar["month"];
                $this->categoriaPrincipal[$this->contador]["numComentarios"]  = $numComentarios;
                $contador++;
                $this->contador++;
            }
        }
    }

    /*
     * Obtenemos las categorias principales
     */
    public function getCategoriaPrincipal(){
        var_dump($this->categoriaPrincipal);
    }

    /*
     * Enviamos las urls del vector
     */
    public function getUrlDetalle(){
        return $this->vectorUrlsPadres;
    }

    /*
     * Pasamod el content del detalle
     * de todos los post
     */
    public function setPadreContent($vectorContent){
        $this->padreContent = $vectorContent;
        //$vectorCadena       = $this->scrapePadre($this->padreContent);
        foreach($this->padreContent as $content){
            $detalle = $this->queryDetallePost($content);
            $this->guardarContentPadres($content);
        }
        $this->writeCsv();
    }

    /*
     * Cortamos el set Index Content
     */
    public function scrapePadre($contenidoVector){
        $inicio        = '<div class="single-post">';
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
    public function guardarContentPadres($contenidoVector){
        array_push($this->vectorDetalleContent,$this->queryDetallePost($contenidoVector));
    }

    /*
     * Devolvemos vector detalle content
     */
    public function getDetalleContent(){
        return $this->vectorDetalleContent;
    }

    /*
     * Creamos csv
     */
    public function writeCsv(){
        // csv
        $output   = fopen('post_import.csv', 'w');
        $vector   = array();
        array_push($vector,$this->getLabelCsv());
        $contador = 0;
        foreach ($this->categoriaPrincipal as $value) {
            $id             = $contador + 1;
            $post_id        = $id;
            $post_name      = $value['titulo'];
            $post_author    = "editor@davidberruezo.com";
            $post_date      = $this->convertDate($value['dia'],$value['mes']);
            $post_type      = "post";
            $post_status    = "publish";
            $post_tags      = "prestashop";
            $post_title     = $value['titulo'];
            $post_content   = $this->vectorDetalleContent[$contador];
            $post_category  = "prestashop";
            $custom_field1  = $value['imagen'];
            $custom_field2  = "left";
            $vectorCampos  = array($post_id,$post_name,$post_author,$post_date,$post_type,$post_status,$post_title,$post_content,$post_category,$post_tags,$custom_field1,$custom_field2);
            array_push($vector,$vectorCampos);
            $contador++;
        }
        foreach($vector as $field){
            fputcsv($output, $field,',');
        }
        fclose($output);
    }


    public function getLabelCsv(){
        $vector = array(
            "post_id",
            "post_name",
            "post_author",
            "post_date",
            "post_type",
            "post_status",
            "post_tags",
            "post_title",
            "post_content",
            "post_category",
            "post_tags",
            "Imagen",
            "posicion"
        );
        return $vector;
    }

    /*
     * Convertimos la fecha
     */
    public function convertDate($parametroDia,$parametroMes){
        $dia   = $parametroDia;
        $mes   = $parametroMes;
        $year  = '2016';
        $fecha = $dia.'-'.$mes.'-'.$year;
        $fechaActual = DateTime::createFromFormat('d-M-Y', $fecha);
        $fechaActual->format('Y-m-d');
        $fechaConvertida = $fechaActual->date;
        return $fechaConvertida;
    }

    /*
     * Consultamos el detalle del post
     */
    public function queryDetallePost($content){
        $dom               = new DOMDocument();
        $dom->loadHTML($content);
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "post-content";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        /*
        $contenido         = "";
        if ($elemento->length > 0){
            foreach($elemento as $element){
                $contenido = $element->nodeValue;
            }
        }
        return $contenido;
        */
        $htmlString = $dom->saveHTML($elemento->item(0));
        return $htmlString;
    }


    /*
     * Convertir la url
     */
    public function convertirUrl($url){
        $urlConvertida = str_replace("http://nemops.com/","http://www.nemops.net/",$url);
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