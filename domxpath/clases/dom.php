<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class Dom{
    // file_getcontents
    private $urls		            = "";
    private $host   	            = "";
    private $path   	            = "";
    private $scheme                 = "";
    // DomDocument
    private $document	            = "";
    private $xpath	                = "";
    private $pageSource             = "";
    private $categoriasNameUrl      = array();
    // Contador total Productos
    private $contadorTotalProductos = 0;
    private $caracteristicasDefault = array();
    public function __construct($vector)
    {
        $this->urls     = $vector;
        $this->document = new DOMDocument();
    }

    public function setVectorCategorias($vector){
        $this->urls     = $vector;
        $this->document = new DOMDocument();
    }

    /*
     * Consulta para listado de Categorias
     * para imagenes,numero productos,listado de productos, desc corta
     */
    public function getCategoriesIndex(){
        $content = $this->urls[0];
        //echo $content;
        // Elementos 3 niveles
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        //echo "------------------ Categorias ----------------<br>";
        // Cogemos las imagenes del parent
        $vectorImagenes  = $this->getImagenesIndexCategorias();
        // Elementos 3 niveles
        $elemento        = $this->document->getElementById("left-nav");
        $level0          = 0;
        $level1          = 0;
        $level2          = 0;
        $contadorCsv     = 3;
        foreach ($elemento->childNodes as $li) {
            if ($li->nodeType == 1) {
                $anchors = $li->getElementsByTagName('a');
                $spans   = $li->getElementsByTagName('span');
                $uls     = $li->getElementsByTagName('ul');
                foreach ($anchors as $anchor) {
                    $mystring = $anchor->parentNode->getAttribute("class");
                    $findmeLevel0 = 'level0';
                    $posLevel0 = strpos($mystring, $findmeLevel0);
                    if ($posLevel0 !== false) {
                        $this->categoriasNameUrl[$level0]                = array();
                        $this->categoriasNameUrl[$level0]["id"]          = $contadorCsv;
                        $this->categoriasNameUrl[$level0]["name"]        = rtrim(ltrim($anchor->nodeValue));
                        $this->categoriasNameUrl[$level0]["url"]         = $anchor->getAttribute("href");
                        $this->categoriasNameUrl[$level0]["parent"]      = 2;
                        $this->categoriasNameUrl[$level0]["imagen"]      = $vectorImagenes[$level0];
                        $this->categoriasNameUrl[$level0]["numeroHijos"] = count($vectorImagenes);
                        $this->categoriasNameUrl[$level0]["content"]     = "";
                        $this->categoriasNameUrl[$level0]["hijos"]       = array();
                        $level0++;
                        $contadorCsv++;
                        $contadorPadre  = $contadorCsv;
                        $level1 = 0;
                        $level2 = 0;
                        $encontradoHijos = FALSE;
                    } else {
                        $findmeLevel1 = 'level1';
                        $posLevel1 = strpos($mystring, $findmeLevel1);
                        if ($posLevel1 !== false) {
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["id"]     = $contadorCsv;
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["url"]    = $anchor->getAttribute("href");
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["name"]   = rtrim(ltrim($anchor->nodeValue));
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["parent"] = ($contadorPadre-1);
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["imagen"] = "";
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["numeroNietos"] = 0;
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["content"]= "";
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["numeroProductos"] = 0;
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["productos"]       = array();
                            $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["nietos"]          = array();
                            $parent = (int)($contadorPadre-1);
                            $level1++;
                            $contadorCsv++;
                            $contadorNieto = $contadorCsv;
                            //echo "name hijo: ".rtrim(ltrim($anchor->nodeValue))."<br>";
                            //echo "url hijo: ".$anchor->getAttribute("href")."<br>";
                        } else {
                            $findmeLevel2 = 'level2';
                            $posLevel2 = strpos($mystring, $findmeLevel2);
                            if ($posLevel2 !== false) {
                                if (!is_array($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"])){
                                    $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"] = array();
                                }
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["id"]        = $contadorCsv;
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["url"]       = $anchor->getAttribute("href");
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"]      = rtrim(ltrim($anchor->nodeValue));
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["parent"]    = (int)($contadorNieto-1);
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["imagen"]    = "";
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["content"]   = "";
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["productos"] = array();
                                $name          = $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"];
                                $parent        = (int)($contadorNieto-1);
                                $level2++;
                                $contadorCsv++;
                                $encontradoHijos = TRUE;
                                $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1-1]["numeroNietos"]                     = $level2;
                                unset($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["productos"]);
                                unset($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["numeroProductos"]);
                            }
                        }
                    }
                }
            }
        }
        return $this->categoriasNameUrl;
        //echo "------------------ Fin Categorias ----------------<br>";
    }

    /*
     * Obtenemos todas las imagenes
     * del index de las categorias
     * padre
     */
    public function getImagenesIndexCategorias(){
        $vectorImagenes = array();
        foreach ($this->urls as $content){
            @$this->document->loadHTML($content);
            $this->xpath    = new DOMXPath($this->document);
            $tag            = "div";
            $class          = "home-category-box";
            $consulta       = "//".$tag."[@class='".$class."']";
            $resultados     = $this->xpath->query($consulta);
            if ($resultados->length > 0){
                $contador = 0;
                foreach($resultados as $imagenes){
                    if ($contador == 0){
                        $todasImagenes = $imagenes->getElementsByTagName("img");
                        if ($todasImagenes->length > 0){
                            foreach($todasImagenes as $imagen){
                                $urlImagen = $imagen->getAttribute("src");
                                echo "url imagen categorias padre: ".$urlImagen."<br>";
                                array_push($vectorImagenes,$urlImagen);
                            }
                        }
                    }
                    $contador++;
                }
            }
        }
        return $vectorImagenes;
    }


    /*
     * Hacemos las consultas para el número de productos
     * la desc corta, images de categorias que tengan hijos
     */
    public function getListadoCategorias(){
        $contadorPadre = 0;
        $contadorNieto = 0;
        $contadorUrls  = 0;
        $contadorHijo  = 0;
        foreach($this->urls as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])) {
                        foreach ($hijos["nietos"] as $nietos) {
                            //$this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"]       = array();
                            $vectorDescCorta = $this->queryDescCorta($this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"]);
                            $vectorUrl       = $this->queryUrlProducto($this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"]);
                            $numeroProductos = $this->queryTotalesProductosPorCategoria($this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"], $nietos["url"]);
                            $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["numeroProductos"] = $numeroProductos;
                            $id = $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["id"];
                            $productos = $this->crearProductos($numeroProductos, $vectorDescCorta, $vectorUrl, $id);
                            $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"] = $productos;
                            $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"] = "";
                            $contadorNieto++;
                            $contadorUrls++;
                        }
                    }

                    if (isset($this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"])){
                        $numeroProductos = $this->queryTotalesProductosPorCategoria($this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"],$hijos["url"]);
                        //$this->urls[$contadorPadre]["hijos"][$contadorHijo]["numeroNietos"]    = 0;
                        //$this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"]       = array();
                        $vectorDescCorta = $this->queryDescCorta($this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"]);
                        $vectorUrl       = $this->queryUrlProducto($this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"]);
                        $numeroProductos = $this->queryTotalesProductosPorCategoria($this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"],$hijos["url"]);
                        $this->urls[$contadorPadre]["hijos"][$contadorHijo]["numeroProductos"] = $numeroProductos;
                        $id              = $this->urls[$contadorPadre]["hijos"][$contadorHijo]["id"];
                        $products = $this->crearProductos($numeroProductos,$vectorDescCorta,$vectorUrl,$id);
                        $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"] = $products;
                        $this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"] = "" ;

                    }else{
                        $this->urls[$contadorPadre]["hijos"][$contadorHijo]["content"] = "" ;
                        // Cogeremos imagenes solamente
                    }

                    $contadorUrls++;
                    $contadorHijo++;
                }
            }
            $this->urls[$contadorPadre]["content"] = "";
            $contadorUrls++;
            $contadorPadre++;
            $contadorHijo  = 0;
            $contadorNieto = 0;
        }
        //var_dump($this->urls);
        return $this->urls;
    }



    /*
     * Creamos el vector
     * producto como plantilla
     * para todo el numero de productos
     */
    function crearProductos($numero,$vectorDesc,$vectorUrl,$idCategoria){
        $vectorProductos = array();
        for ($i=0;$i<$numero;$i++){
            $this->contadorTotalProductos++;
            $prodCsv = array(
                'url'     => $vectorUrl[$i],
                'content' => "",
                'producto' => array(
                    "ID"                        => $this->contadorTotalProductos,
                    "Active"                    => "",
                    "Name"                      => "",
                    "Categories"                => $idCategoria,
                    "Price"                     => "",
                    "Tax"                       => 31,
                    "Wholesale price"           => "",
                    "OnSale"                    => "",
                    "Discount"                  => "",
                    "DiscountPercent"           => "",
                    "DiscountFrom"              => "",
                    "DiscountTo"                => "",
                    "Reference"                 => "",
                    "SupplierReference"         => "",
                    "Supplier"                  => "",
                    "Manufacturer"              => "",
                    "Ean13"                     => "",
                    "Upc"                       => "",
                    "Ecotax"                    => "",
                    "Width"                     => "",
                    "Height"                    => "",
                    "Depth"                     => "",
                    "Weight"                    => "",
                    "Quantity"                  => "",
                    "MinimalQuantity"           => "",
                    "Visibility"                => "",
                    "AdditionalShippingCost"    => "",
                    "Unity"                     => "",
                    "UnityPrice"                => "",
                    "ShortDescription"          => $vectorDesc[$i],
                    "Description"               => "",
                    "Tags"                      => "",
                    "Metatitle"                 => "",
                    "MetaKeywords"              => "",
                    "MetaDescription"           => "",
                    "UrlRewritten"              => "",
                    "TextStock"                 => "",
                    "TextBackorder"             => "",
                    "Avaiable"                  => "",
                    "ProductAvaiableDate"       => "",
                    "ProductCreationDate"       => "",
                    "ShowPrice"                 => "",
                    "ImageUrls"                 => "",
                    "DeleteExistingImages"      => "",
                    "Feature"                   => "",
                    "AvaiableOnline"            => "",
                    "Condition"                 => "",
                    "Customizable"              => "",
                    "Uploadable"                => "",
                    "TextFields"                => "",
                    "OutStock"                  => "",
                    "IdNameShop"                => "",
                    "AdvancedStockManagement"   => "",
                    "DependsOnStock"            => "",
                    "Warehouse"                 => ""
                )
            );
            array_push($vectorProductos,$prodCsv);
        }
        //var_dump($vectorProductos);
        return $vectorProductos;
    }


    /*
     * Obtemeos las imagenes
     * de las categorias
     */
    public function querytListadoCategoriasImagenes($content){
        $vectorImagenes = array();
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
                            //echo "url Imagen: ".$urlImagen."<br>";
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
     * Obtenemos los totales de los productos
     */
    public function queryTotalesProductosPorCategoria($content,$url){
        echo "url: ".$url."<br>";
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $tag            = "div";
        $class          = "pager";
        $consulta       = "//".$tag."[@class='".$class."']";
        $resultados     = $this->xpath->query($consulta);
        var_dump($resultados);
        if ($resultados->length > 0){
            foreach($resultados as $resultado){
                $numero   = rtrim(ltrim($resultado->nodeValue));
                $findme   = 'totales';
                $pos = strpos($numero, $findme);
                if ($pos === false) {
                    $numero = str_ireplace("Artículo(s)"," ",$numero);
                    $numero = rtrim(ltrim($numero));
                } else {
                    $vector = explode(" ",$numero);
                    $numero = rtrim(ltrim($vector[3]));
                }
            }
            echo "url: ".$url."<br>";
            echo "Numero de productos: ".$numero."<br>";
        }
        return $numero;
    }

    /*
     * Cogemos la url del listado
     * de los productos
     */
    public function queryUrlProducto($content){
        $vectorAnchors  = array();
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $tag            = "a";
        $class          = "product-image";
        $consulta       = "//".$tag."[@class='".$class."']";
        $resultados     = $this->xpath->query($consulta);
        if ($resultados->length > 0) {
            foreach ($resultados as $resultado) {
                array_push($vectorAnchors,$resultado->getAttribute("href"));
                //echo "url productos: ".$resultado->getAttribute("href")."<br>";
            }
        }
        return $vectorAnchors;
    }

    /*
     * Cogemos la desc corta de el
     * listado de productos
     */
     public function queryDescCorta($content){
         $vectorDesc     = array();
         @$this->document->loadHTML($content);
         $this->xpath    = new DOMXPath($this->document);
         $cssname        = "desc-product";
         $tag            = "div";
         $consulta       = "//".$tag."[@class='".$cssname."']";
         $elementos      = $this->xpath->query($consulta);
         foreach($elementos as $elemento){
             //echo "Descripcion corta es: ".$elemento->nodeValue."<br><br>";
             $descCorta = rtrim(ltrim($elemento->nodeValue));
             array_push($vectorDesc,$descCorta);
         }
         return $vectorDesc;
     }


    /*
     * Cogemos productos Detalles
     */
     public function getDetalleProducto(){
         $contadorUrls     = 0;
         $contadorPadre    = 0;
         $contadorHijo     = 0;
         $contadorNieto    = 0;
         $contadorProducto = 0;
         foreach($this->urls as $categorias){
             if (isset($categorias["hijos"])){
                 foreach($categorias["hijos"] as $hijos){
                     if (isset($hijos["nietos"])){
                         foreach($hijos["nietos"] as $nietos){
                             foreach($nietos["productos"] as $producto){
                                //echo "id: ".$producto['producto']['ID'];
                                //echo "id: ".$this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['ID'];
                                $vectorNombreReferencia = $this->queryGetNameAndReference($producto['content']);
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Active'] = 1;
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Name'] = $vectorNombreReferencia['name'];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Reference'] = $contadorUrls+1;
                                $vectorImagenes = $this->queryGetImages($producto['content']);
                                $cadena         = "";
                                foreach($vectorImagenes as $imagen){
                                    $cadena.= $imagen.",";
                                }
                                $cadena = substr($cadena,0,strlen($cadena)-1);
                                echo "cadena: ".$cadena."<br>";
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['ImageUrls'] = $cadena;
                                $vectorPrecios = $this->queryGetPriceAndOldPrice($producto['content']);
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Wholesale price'] = $vectorPrecios["Wholesale price"];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Price'] = $vectorPrecios["Price"];
                                $caracString = $this->queryGetCaracteristicas($producto['content']);
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Feature'] = $caracString["feature"];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Description'] = $caracString["descripcion"];
                                $marca = $this->queryGetMarca($producto['content']);
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Quantity']           = 100;
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Manufacturer']       = $marca;
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Tags']               = $vectorNombreReferencia['name'];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['Metatitle']          = $vectorNombreReferencia['name'];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['MetaKeywords']       = $vectorNombreReferencia['name'];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['MetaDescription']    = $vectorNombreReferencia['name'];
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]['producto']['IdNameShop']         = 1;
                                //$producto['content'] = "";
                                $this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]["content"] = "";
                                $contadorProducto++;
                                $contadorUrls++;
                             }
                             $contadorProducto = 0;
                             $contadorNieto++;
                         }
                     }else{
                         foreach($hijos["productos"] as $producto){
                             //echo "id: ".$producto['producto']['ID'];
                             //echo "id: ".$this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['ID'];
                             $vectorNombreReferencia = $this->queryGetNameAndReference($producto['content']);
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Name'] = $vectorNombreReferencia['name'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Reference'] = $contadorUrls+1;
                             $vectorImagenes = $this->queryGetImages($producto['content']);
                             $cadena         = "";
                             foreach($vectorImagenes as $imagen){
                                 $cadena.= $imagen.",";
                             }
                             $cadena = substr($cadena,0,strlen($cadena)-1);
                             echo "cadena: ".$cadena."<br>";
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Active'] = 1;
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['ImageUrls'] = $cadena;
                             $vectorPrecios = $this->queryGetPriceAndOldPrice($producto['content']);
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Wholesale price'] = $vectorPrecios["Wholesale price"];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Price'] = $vectorPrecios["Price"];
                             $caracString = $this->queryGetCaracteristicas($producto['content']);
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Feature'] = $caracString['feature'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Description'] = $caracString['descripcion'];
                             $marca = $this->queryGetMarca($producto['content']);
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Quantity']           = 100;
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Manufacturer']       = $marca;
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Tags']               = $vectorNombreReferencia['name'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['Metatitle']          = $vectorNombreReferencia['name'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['MetaKeywords']       = $vectorNombreReferencia['name'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['MetaDescription']    = $vectorNombreReferencia['name'];
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]['producto']['IdNameShop']         = 1;
                             $this->urls[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]["content"] = "";
                             //$producto['content'] = "";
                             $contadorProducto++;
                             $contadorUrls++;
                         }
                         $contadorProducto = 0;
                     }
                     $contadorHijo++;
                 }
             }
             $contadorPadre++;
         }
         return ($this->urls);
     }


    /*
     * Consulta detalle
     * Nombre,referemcia,precio,antiguo precio, opciones, imágenes, características
     */
    public function queryGetNameAndReference($content){
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $vector = array(
            "name"      => array(),
            "reference" => array()
        );
        $cssname            = "product-shop";
        $tag                = "div";
        $consulta           = "//".$tag."[@class='".$cssname."']";
        $elements           = $this->xpath->query($consulta);
        $contadorProductos  = 0;
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
                            if ($el->hasAttribute("itemprop") && $el->getAttribute("itemprop") == "name") {
                                $nombre = rtrim(ltrim($el->nodeValue));
                                echo "nombre: " . $nombre . "<br>";
                                $nombre = rtrim(ltrim($nombre));
                                $vector["name"] = $nombre;
                                //array_push($vector["name"], $nombre);
                            }
                        }else{
                            $referencia = rtrim(ltrim($el->nodeValue));
                            echo "referencia: ".$referencia."<br>";
                            $referencia = rtrim(ltrim($referencia));
                            $vector["reference"] = $referencia;
                            //array_push($vector["reference"],$referencia);
                        }
                        $contador++;
                    }
                }
            }
            $contadorProductos++;
        }
        return $vector;
    }


    public function queryGetImages($content){
        $vector         = array();
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $cssname        = "prozoom-small-image";
        $tag            = "a";
        $consulta       = "//".$tag."[@class='".$cssname."']";
        $elements       = $this->xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                echo "url imagen: ".$element->getAttribute("href")."<br>";
                array_push($vector,$element->getAttribute("href"));
            }
        }
        return $vector;
    }

    public function queryGetPriceAndOldPrice($content){
        $vector         = array();
        @$this->document->loadHTML($content);
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
                                        $oldPrecio = rtrim(ltrim($oldPrecio));
                                        //echo "Precio antiguo: ".$oldPrecio."<br>";
                                        $vector["Wholesale price"] = $oldPrecio;
                                    }else if ($p->hasAttribute("class") && $p->getAttribute("class") == "special-price"){
                                        $precio = $p->nodeValue;
                                        echo "Precio: ".$precio."<br>";
                                        $precio = rtrim(ltrim($precio));
                                        $vector["Price"] = $precio;
                                    }
                                    $contador++;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $vector;
    }

    public function queryGetCaracteristicas($content){
        // th = description
        // td = value
        $vector         = array();
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $atributoValue  = "data-table";
        $tag            = "table";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $this->xpath->query($consulta);
        $caracValue     = array();
        $caracTitle     = array();
        $caracString    = "";
        if ($elements->length > 0){
            foreach($elements as $element){
                $tds = $element->getElementsByTagName("td");
                $ths = $element->getElementsByTagName("th");
                foreach($tds as $td){
                    //var_dump($tr);
                    //echo ($td->nodeValue);
                    //echo "<br><br>";
                    array_push($caracValue,ltrim(rtrim($td->nodeValue)) );
                }
                foreach($ths as $th){
                    //var_dump($td);
                    $encontrado = FALSE;
                    foreach($this->caracteristicasDefault as $default){
                        if ($default == ltrim(rtrim($th->nodeValue))){
                            $encontrado = TRUE;
                        }
                    }
                    if ($encontrado == FALSE){
                        array_push($this->caracteristicasDefault,ltrim(rtrim($th->nodeValue)));
                    }
                    array_push($caracTitle,ltrim(rtrim($th->nodeValue)) );
                    //echo ($th->nodeValue);
                    //echo "<br><br>";
                }
            }
        }
        $contador = 0;
        foreach($caracValue as $valor){
            if ($caracTitle[$contador] != "Descripción" && $caracTitle[$contador] != "Marca" ){
                $caracString.= $caracTitle[$contador].":".$valor.",";
            }else if ($caracTitle[$contador] == "Descripción"){
                $descripcion = rtrim(ltrim($valor));
            }
            $contador++;
        }
        echo $caracString."<br>";
        $vector = array(
            "descripcion" => $descripcion,
            "feature"     => $caracString
        );
        //return $caracString;
        return $vector;
        echo "<br><br>";
    }

    public function queryGetMarca($content){
        @$this->document->loadHTML($content);
        $this->xpath    = new DOMXPath($this->document);
        $atributoValue  = "tiempo-entrega-p";
        $tag            = "p";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $this->xpath->query($consulta);
        var_dump($elements);
        if ($elements->length > 0){
            foreach($elements as $element){
                $consulta = "span";
                $spans = $this->xpath->query($consulta,$element);
                foreach($spans as $span){
                    echo "span: ".$span->nodeValue;
                    $marca = $span->nodeValue;
                }
            }
        }
        return $marca;
    }

    /*
    public function getOptions(){
        $this->xpath    = new DOMXPath($this->document);
        $cssname        = "options-list";
        $tag            = "ul";
        $consulta       = "//".$tag."[@class='".$cssname."']";
        $elements       = $this->xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                $consultaSpan = "li/span[@class='label']";
                $spans = $this->xpath->query($consultaSpan, $element);
                if ($spans->length > 0){
                    foreach($spans as $span){
                        echo "La caracteristica es: ".$span->nodeValue."<br>";
                    }
                }
            }
        }
        echo "<br><br>";
    }
    */
}
?>