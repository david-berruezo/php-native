<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class Dom{
    // file_getcontents
    private $urls		= "";
    private $host   	= "";
    private $path   	= "";
    private $scheme     = "";
    // DomDocument
    private $document	= "";
    private $xpath	    = "";
    private $pageSource = "";

    public function __construct($vector)
    {
        $this->urls     = $vector;
        $this->document = new DOMDocument();
    }

    public function setVectorCategorias($vector){
        $this->urls     = $vector;
        $this->document = new DOMDocument();
    }

    public function getElementsByClassName($cssname){
        $elementos = array();
        foreach($this->urls as $contenido) {
            @$this->document->loadHTML($contenido);
            $this->xpath    = new DOMXPath($this->document);
            $elements  = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $cssname ')]");
            array_push($elementos,$elements);
        }
        return $elementos;
    }
    public function getElementsByTagClassName($tag,$class){
        $elementos = array();
        foreach($this->urls as $contenido) {
            @$this->document->loadHTML($contenido);
            $this->xpath    = new DOMXPath($this->document);
            $elements       = $this->xpath->query("//li[contains(concat(' ',@class, ' '), 'item ')]");
            array_push($elementos,$elements);
        }
        return $elementos;
    }
    public function getElementsByTagClassNameOther($tag,$class){
        $elementos = array();
        foreach($this->urls as $contenido) {
            @$this->document->loadHTML($contenido);
            $this->xpath = new DOMXPath($this->document);
            $elements    = $this->xpath->query("//".$tag."[contains(concat(' ',@class, ' '), '".$class. " ')]");
            array_push($elementos,$elements);
        }
        return $elementos;
    }
    public function getElementsByQueryName($tag,$caracs){
        $elementos = $this->xpath->query('//'.$tag.'[@class="'.$caracs.'"]');
        return $elementos;
    }
    public function getElementsByQueryClassName($class){
        $elementos = $this->xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' reference ')]");
        return $elementos;
    }
    public function getElementsByTagName($tagname)
    {
        $elementos = $this->document->getElementsByTagName($tagname);
        return $elementos;
    }

    public function getElementsById($id){
        $elementos = array();
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $elemento = $this->document->getElementById($id);
            array_push($elementos,$elemento);
        }
        return $elementos;
    }

    public function getAttribute(){
        $elementos = array();
        $tag   = "span";
        $valor = "price";
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $elementos = $this->xpath('//span[@itemprop="price"]');
            array_push($elementos,$elemento);
        }
        return $elementos;
    }

    public function getVectorElementsById($id){
        $elementos = array();
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $elemento = $this->document->getElementsByTagName($id);
            array_push($elementos,$elemento);
        }
        return $elementos;
    }

    /*
     * Consulta para listado de Categorias
     * e imagenes de categorias
     */
    public function getListadoCategoriasImagenes(){
        $contadorUrls  = 0;
        $contadorPadre = 0;
        $contadorHijo  = 0;
        foreach($this->urls as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){

                        }
                        $imagen = $this->querytListadoCategoriasImagenes($this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"]);
                        $this->urls[$contadorPadre]["hijos"][$contadorHijo]["imagen"] = $imagen;
                    }
                    $contadorUrls++;
                    $contadorHijo++;
                }
            }
            $imagenes = $this->querytListadoCategoriasImagenes($this->urls[$contadorPadre]["content"]);
            $contador = 0;
            foreach($imagenes as $imagen){
                $this->urls[$contadorPadre]["hijos"][$contador]["imagen"] = $imagen;
                $contador++;
            }
            $contadorUrls++;
            $contadorPadre++;
        }
        return ($this->urls);
    }

    public function querytListadoCategoriasImagenes($content){
        var_dump($content);
        $vectorImagenes = array();
        $this->document = new DOMDocument();
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $tag            = "div";
        $class          = "widget em-widget-new-products-grid";
        $consulta       = "//".$tag."[@class='".$class."']";
        $widget         = $this->xpath->query($consulta);
        $contador       = 0;
        if ($widget->length > 0){
            foreach($widget as $res){
                if ($contador == 0){
                    $resultados = $res->getElementsByTagName("img");
                    if ($resultados->length > 0){
                        foreach($resultados as $img){
                            $urlImagen = $img->getAttribute("src");
                            echo "url imagen es: ".$urlImagen."<br>";
                            array_push($vectorImagenes,$urlImagen);
                        }
                    }
                }
                $contador++;
            }
        }
        return $vectorImagenes;
    }

    /*
     * Consulta para el listado de productos
     * leemos todas las desc cortas de los
     * productos
     */
    public function getDescCorta(){
        $elementos      = array();
        $contadorTotal  = 0;
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $this->xpath    = new DOMXPath($this->document);
            $cssname        = "desc-product";
            $tag            = "div";
            $consulta       = "//".$tag."[@class='".$cssname."']";
            $elements       = $this->xpath->query($consulta);
            foreach($elements as $elemento){
                //echo "Descripcion corata es: ".$elemento->nodeValue."<br><br>";
                array_push($elementos,$elemento->nodeValue);
            }
            //echo "Contador Desc Corta Total: ".$contadorTotal."<br>";
            $contadorTotal++;
        }
        return $elementos;
    }

    /*
     * Consultas para el detalle de producto
     * precio, antiguo precio, nombre y referencia
     * imagenes, caracteristicas, descripcion
     */
    public function getPriceAndOldPrice(){
        $elementos = array(
            "price"    => array(),
            "oldprice" => array()
        );
        foreach($this->urls as $url) {
            @$this->document->loadHTML($url);
            $this->xpath    = new DOMXPath($this->document);
            $atributoValue  = "tiempo-entrega-div";
            $tag            = "div";
            $consulta       = "//".$tag."[@class='".$atributoValue."']";
            $objeto         = $this->xpath->query($consulta);
            if ($objeto->length > 0){
                foreach($objeto as $tiempoEntrega){
                    $itemType = $tiempoEntrega->nextSibling->nextSibling;
                    $res = $itemType->getElementsByTagName("div");
                    if ($res->length > 0){
                        foreach($res as $div){
                            if ($div->hasAttribute("class") && $div->getAttribute("class") == "price-box"){
                                $plist = $div->getElementsByTagName("p");
                                $contador = 0;
                                if ($plist->length > 0){
                                    foreach($plist as $p){
                                        if ($p->hasAttribute("class") && $p->getAttribute("class") == "old-price"){
                                            $oldPrecio = $p->nodeValue;
                                            //echo "Precio antiguo: ".$oldPrecio."<br>";
                                            array_push($elementos["oldprice"],$oldPrecio);
                                        }else if ($p->hasAttribute("class") && $p->getAttribute("class") == "special-price"){
                                            $precio = $p->nodeValue;
                                            array_push($elementos["price"],$precio);
                                            //echo "Precio: ".$precio."<br>";
                                        }
                                        $contador++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $elementos;
    }

    public function getNameAndReference(){
        $vector = array(
            "name"      => array(),
            "reference" => array()
        );
        foreach($this->urls as $url) {
            @$this->document->loadHTML($url);
            $this->xpath = new DOMXPath($this->document);
            $cssname        = "product-shop";
            $tag            = "div";
            $consulta = "//".$tag."[@class='".$cssname."']";
            $elements = $this->xpath->query($consulta);
            if ($elements->length > 0){
                $contador = 0;
                foreach($elements as $elemento){
                    $cssname        = "product-name";
                    $consulta       = "div[@class='".$cssname."']";
                    $elementos      = $this->xpath->query($consulta,$elemento);
                    $contador       = 0;
                    if ($elementos->length > 0){
                        foreach($elementos as $el){
                            if ($contador == 0){
                                $nombre     = rtrim(ltrim($el->nodeValue));
                                //echo "nombre: ".$nombre."<br>";
                                array_push($vector["name"],$nombre);
                            }else{
                                $referencia = rtrim(ltrim($el->nodeValue));
                                //echo "referencia: ".$referencia."<br>";
                                array_push($vector["reference"],$referencia);
                            }
                            $contador++;
                        }
                    }
                }
            }
        }
        return $vector;
    }

    public function getImages(){
        $elementos      = array();
        $contador       = 0;
        $contadorTotal  = 0;
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $this->xpath    = new DOMXPath($this->document);
            $cssname        = "prozoom-small-image";
            $tag            = "a";
            $consulta       = "//".$tag."[@class='".$cssname."']";
            $elements       = $this->xpath->query($consulta);
            if ($elements->length > 0){
                foreach($elements as $element){
                    //echo "url imagen: ".$element->getAttribute("href")."<br>";
                    if (!isset($elementos[$contador]["hijos"])){
                        $elementos[$contador]["hijos"] = array();
                    }
                    array_push($elementos[$contador]["hijos"],$element->getAttribute("href"));
                }
            }else{
                $elementos[$contador]["hijos"] = array();
            }
            $contador++;
            //echo "Contador Images Total: ".$contadorTotal."<br>";
            $contadorTotal++;
        }
        return $elementos;
    }


    public function getCaracteristicas(){
        $elementos      = array(
            //"th" => array(),
            //"td" => array()
        );
        $contador = 0;
        foreach($this->urls as $url){
            @$this->document->loadHTML($url);
            $this->xpath    = new DOMXPath($this->document);
            $atributoValue  = "data-table";
            $tag            = "table";
            $consulta       = "//".$tag."[@class='".$atributoValue."']";
            $elements       = $this->xpath->query($consulta);
            if ($elements->length > 0){
                foreach($elements as $element){
                    $tds = $element->getElementsByTagName("td");
                    $ths = $element->getElementsByTagName("th");
                    foreach($tds as $td){
                        //var_dump($tr);
                        //echo ($tr->nodeValue);
                        //echo "<br><br>";
                        if (!isset($elementos[$contador]["td"])){
                            $elementos[$contador]["td"] = array();
                        }
                        array_push($elementos[$contador]["td"],$td->nodeValue);
                    }
                    foreach($ths as $th){
                        //var_dump($td);
                        //echo ($td->nodeValue);
                        //echo "<br><br>";
                        if (!isset($elementos[$contador]["th"])){
                            $elementos[$contador]["th"] = array();
                        }
                        array_push($elementos[$contador]["th"],$th->nodeValue);
                    }
                }
            }
            $contador++;
        }
        return $elementos;
    }


}
//$elements = $this->xpath->query("//div[@class="some-descendant"]//div[@class="some-descendant-of-that-descendant"]");
//$elementos = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' pages ')]");
?>

