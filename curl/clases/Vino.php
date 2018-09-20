<?php
namespace clases;
class Vino Extends Multicurl{
    // Vectores
    private $categorias = array(
        "http://www.vinoseleccion.com/regiones/rioja",
        "http://www.vinoseleccion.com/regiones/ribera-del-duero",
        "http://www.vinoseleccion.com/regiones/toro",
        "http://www.vinoseleccion.com/regiones/rias-baixas"
    );
    private $paginasListado           = array();
    private $productosUrl             = array();
    private $productosTitulo          = array();
    private $productosDesc            = array();
    private $productosDescLarga       = array();
    private $productosPrecio          = array();
    private $productosIGeneral        = array();
    private $productosCata            = array();
    private $productosSubtitulo       = array();
    private $productosImagenes        = array();
    private $productosCaracteristicas = array();
    private $caracteristicasNombre    = array();
    private $productosReferencias     = array();
    private $productosIds             = array();
    private $caracteristicasDefault   = array(
        'Tipo de Vino',
        'Bodega',
        'Regiones',
        'Variedad de Uva',
        'Enólogo',
        'Bodeguero',
        'Tipo de botella',
        'Capacidad (cl)',
        'Servicio',
        'Embotellado',
        'Consumo',
        'Acidez total (g/l)',
        'Acidez volátil (g/l)',
        'Azúcar (g/l)',
        'PH',
        'Graduación (% vol.)',
        'Tipo de barrica',
        'Permanencia en Barrica',
        'Curva consumo',
        'Densidad',
        'Extracto seco'
    );
    // Objeto Dom
    private $dom;
    public function __construct(){
        // Multi Curl
        parent::__construct($this->categorias);
        $this->setContentAndOptions();
        $content = $this->getContent();
        // Dom Object
        $this->dom = new Dom($content);
        // Inicializamos vectores
        $contador = 0;
        foreach($this->categorias as $categoria){
            $this->productosUrl[$contador]             = array();
            $this->productosTitulo[$contador]          = array();
            $this->productosDesc[$contador]            = array();
            $this->productosDescLarga[$contador]       = array();
            $this->productosPrecio[$contador]          = array();
            $this->productosIGeneral[$contador]        = array();
            $this->productosCata[$contador]            = array();
            $this->productosSubtitulo[$contador]       = array();
            $this->productosImagenes[$contador]        = array();
            $this->productosCaracteristicas[$contador] = array();
            $this->caracteristicasNombre[$contador]    = array();
            $this->productosReferencias[$contador]     = array();
            $this->productosIds[$contador]             = array();
            $contador++;
        }
    }
    public function getPages($pages){
        $vector   = $this->dom->getElementsByClassName($pages);
        //var_dump($vector);
        $contador = 0;
        foreach ($vector as $elementos){
            if ($elementos->length > 0) {
                foreach($elementos as $child) {
                    $numeroPaginas = $child->textContent;
                    $numeroPaginas = explode(":", $numeroPaginas);
                    $numeroPaginas = ltrim(rtrim($numeroPaginas[1]));
                    $numeroPaginas = substr($numeroPaginas, strlen($numeroPaginas) - 1, strlen($numeroPaginas));
                    for ($i = 0; $i < $numeroPaginas; $i++) {
                        $total = $i + 1;
                        $link = $this->categorias[$contador];
                        $this->paginasListado[$contador][$i] = $link . "?p=" . $total;
                    }
                    $paginas[$contador][$i] = $link . "?p=" . $total;
                }
            }else{
                    $link                     = $this->categorias[$contador];
                    $this->paginasListado[$contador][0] = $link ."?p=1";
            }
            $contador++;
        }
        //var_dump($this->paginasListado);
    }

    public function getProductList(){
        $paginas                   = array();
        $contadorCategoria         = 0;
        $contadorPagina            = 0;
        $contadorProducto          = 0;
        $descripcion               = "";
        $indiceActual              = count($this->paginasListado[$contadorCategoria]);
        foreach($this->paginasListado as $pagina){
            foreach($pagina as $url){
                array_push($paginas,$url);
            }
        }
        parent::__construct($paginas);
        $this->setContentAndOptions();
        $content = $this->getContent();
        // Dom Object
        $this->dom  = new Dom($content);
        $tag        = "li";
        $class      = "item ";
        $vectorProductos  = $this->dom->getElementsByTagClassName($tag,$class);
        foreach ($vectorProductos as $productos){
            //echo ("productos: ".$productos->length."<br>");
            if ($contadorPagina == $indiceActual){
                $contadorCategoria++;
                $indiceActual+= count($this->paginasListado[$contadorCategoria]);
            }
            $contadorPagina++;
            if ($productos->length > 0) {
                foreach ($productos as $producto) {
                    $hijos = $producto->childNodes;
                    foreach ($hijos as $hijo) {
                        if ($hijo->tagName == "a") {
                            $url = $hijo->getAttribute("href");
                            array_push($this->productosUrl[$contadorCategoria],$url);
                            //echo "url: ".$url."<br>";
                        }
                        if ($hijo->tagName == "h2") {
                            $nombre = ltrim($hijo->textContent);
                            array_push($this->productosTitulo[$contadorCategoria],$nombre);
                            //echo "nombre: ".$nombre."<br>";
                        }
                        if ($hijo->tagName == "p") {
                            if ($hijo->getAttribute("class") == "sdesc clearer") {
                                $descripcion = $hijo->textContent;
                            } else if ($hijo->getAttribute("class") == "desc clearer") {
                                $descripcion .= " " . $hijo->textContent;
                            }
                            //echo "descripcion: ".$descripcion."<br>";
                        }
                        if ($hijo->tagName == "div") {
                            $nieto = $hijo->firstChild;
                            if ($nieto->nodeName != "div") {
                                $hermano = $nieto->nextSibling;
                                $bisnieto = $hermano->nextSibling->firstChild;
                                $ultimo = $bisnieto->nextSibling->nextSibling;
                                $precio = ltrim(rtrim($ultimo->textContent));
                            } else {
                                $bisnieto = $nieto->firstChild;
                                $hermano = $bisnieto->nextSibling->nextSibling;
                                $precio = ltrim(rtrim($hermano->textContent));
                            }
                            array_push($this->productosPrecio[$contadorCategoria],$precio);
                            //echo "precio: ".$precio."<br>";
                        }
                    }
                    $contadorProducto++;
                    array_push($this->productosIds[$contadorCategoria],$contadorProducto);
                    array_push($this->productosDesc[$contadorCategoria],$descripcion);
                }
            }
            /*
            echo ("------- Valores ------<br>");
            echo "indice: ".$indiceActual. "<br>";
            echo "pagina: ".$contadorPagina."<br>\n";
            echo "categoria: ".$contadorCategoria."<br>\n";
            echo "------------ URL ----------<br>\n";
            var_dump($this->productosUrl);
            echo "------------ TITULO ----------<br>\n";
            var_dump($this->productosTitulo);
            echo "------------ DESC ----------<br>\n";
            var_dump($this->productosDesc);
            echo "------------ PRECIO ----------<br>\n";
            var_dump($this->productosPrecio);
            echo "------------ IDS ----------<br>\n";
            var_dump($this->productosIds);
            echo ("----------- Fin ------------<br>");
            */
        }
    }
    public function getProductDetail(){
        $paginas                   = array();
        $contadorCategoria         = 0;
        $contadorPagina            = 0;
        $contadorProducto          = 0;
        $indiceActual              = count($this->productosUrl[$contadorCategoria]);
        foreach($this->productosUrl as $pagina){
            foreach($pagina as $url){
                array_push($paginas,$url);
            }
        }
        parent::__construct($paginas);
        $this->setContentAndOptions();
        $content = $this->getContent();
        // Dom Object
        $this->dom  = new Dom($content);
        $tag        = "div";
        $class      = "product-view";
        $vectorProductos  = $this->dom->getElementsByTagClassNameOther($tag,$class);
        foreach ($vectorProductos as $productos) {
            if ($contadorPagina == $indiceActual) {
                $contadorCategoria++;
                $indiceActual += count($this->productosUrl[$contadorCategoria]);
            }
            $contadorPagina++;
            if ($productos->length > 0) {
                foreach($productos as $elemento){
                    //var_dump($elemento);
                    // product_view|product_essential|nodisplay--product_shop|product_name|h1--h2
                    // product_view|product_essential|form|nodisplay--product_shop|product_name|h1--h2
                    //echo "contadorCategoria: ".$contadorCategoria." contadorPaginas: ".$contadorPagina." contador: ".$contador." contadorProdcutos: ".$contadorProductos."<br>\n";
                    $form               = $elemento->firstChild->firstChild;
                    if (isset($form) && $form->tagName == "form"){
                        $productNameh2      = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->firstChild->nextSibling;
                        $stdDescriptionP    = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->nextSibling->firstChild;
                        $imagen             = $elemento->firstChild->firstChild->firstChild->nextSibling->nextSibling->firstChild->firstChild;
                    }else{
                        $productNameh2      = $elemento->firstChild->firstChild->nextSibling->firstChild->firstChild->nextSibling;
                        $stdDescriptionP    = $elemento->firstChild->firstChild->nextSibling->firstChild->nextSibling->firstChild;
                        $imagen             = $elemento->firstChild->firstChild->nextSibling->nextSibling->firstChild->firstChild;
                    }
                    $caracs = "general-features";
                    $supercaracs  = $this->dom->getElementsByQueryName($tag,$caracs);
                    //var_dump($supercaracs);
                    $carac = $supercaracs->item(0);
                    $vectorCaracteristicas = array();
                    foreach ($carac->childNodes as $caracvalue){
                        if ( ($caracvalue->getAttribute("class")) && $caracvalue->getAttribute("class") == "content" ){
                            $caracUl = $caracvalue->firstChild;
                            //echo "----------- Caracteristicas ----------<br>\n";
                            foreach ($caracUl->childNodes as $li){
                                $valor = explode(":",$li->nodeValue);
                                for ($i=0;$i<count($this->caracteristicasDefault);$i++){
                                    $campo1 = (string)ltrim(rtrim($li->firstChild->nodeValue));
                                    $campo2 = (string)($this->caracteristicasDefault[$i].":");
                                    if ($campo1 == $campo2){
                                        $vectorCaracteristicas[$i] = $valor[1];
                                        //echo "Encontrado: ".$li->firstChild->nodeValue . " ".$valor[1]."<br>\n";
                                    }
                                }
                                //$vectorCaracteristicas[$li->firstChild->nodeValue] = $valor[1];
                                $encontrado = false;
                                // Colocamos todas las caracteristica nuevas que se van encontrando
                                foreach($this->caracteristicasNombre as $caracteristica){
                                    if ($caracteristica == $li->firstChild->nodeValue){
                                        $encontrado = TRUE;
                                    }
                                }
                                if (!$encontrado){
                                    array_push($this->caracteristicasNombre,$li->firstChild->nodeValue);
                                }
                            }
                            //echo "----------- Fin ----------<br>\n";
                        }
                    }
                    $referencias = $this->dom->getElementsByQueryClassName("reference");
                    $ref = $referencias->item(0)->nodeValue;
                    $ref = explode('Ref. ',$ref);
                    $ref = $ref[1];
                    //$productId          = $productId+1;
                    $informacionGeneral = $elemento->firstChild->nextSibling->firstChild;
                    $notasDeCata        = $elemento->firstChild->nextSibling->firstChild->nextSibling;
                    $informacionGeneral = $informacionGeneral->nodeValue;
                    if ($notasDeCata){$notasDeCata        = $notasDeCata->nodeValue;}
                    $subtitulo          = $productNameh2->nodeValue;
                    if ($stdDescriptionP){$descripcion        = $stdDescriptionP->nodeValue;}
                    // 1.- Cuado hay descuento 35%
                    // 2.- Cuando son ultimas botellas
                    if (property_exists($imagen, 'wholeText') && $imagen->wholeText != ' ultimas botellas'){
                        $imagen             = $elemento->firstChild->firstChild->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
                    }else if (property_exists($imagen, 'wholeText') && $imagen->wholeText == ' ultimas botellas'){
                        $imagen             = $elemento->firstChild->firstChild->firstChild->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
                    }
                    $imagen             = $imagen->getAttribute("src");
                    //$caracteristicasTextoValue = $generalFeatures->childNodes;
                    array_push($this->productosIGeneral[$contadorCategoria],$informacionGeneral);
                    array_push($this->productosSubtitulo[$contadorCategoria],$subtitulo);
                    array_push($this->productosDescLarga[$contadorCategoria],$descripcion);
                    array_push($this->productosImagenes[$contadorCategoria],$imagen);
                    array_push($this->productosCata[$contadorCategoria],$notasDeCata);
                    array_push($this->productosCaracteristicas[$contadorCategoria],$vectorCaracteristicas);
                    array_push($this->productosReferencias[$contadorCategoria],$ref);
                    //var_dump($vectorCaracteristicas);
                }
            }
            /*
            echo ("------- Valores ------<br>");
            echo "indice: ".$indiceActual. "<br>";
            echo "pagina: ".$contadorPagina."<br>\n";
            echo "categoria: ".$contadorCategoria."<br>\n";
            echo "------------ IGENERAL ----------<br>\n";
            var_dump($this->productosIGeneral);
            echo "------------ SUBTITULO ----------<br>\n";
            var_dump($this->productosSubtitulo);
            echo "------------ DESC LARGA ----------<br>\n";
            var_dump($this->productosDescLarga);
            echo "------------ IMAGENES ----------<br>\n";
            var_dump($this->productosImagenes);
            echo "------------ CATA ----------<br>\n";
            var_dump($this->productosCata);
            echo "------------ CARACTERISTICAS ----------<br>\n";
            var_dump($this->productosCaracteristicas);
            echo "------------ REFERENCIAS ----------<br>\n";
            var_dump($this->productosReferencias);
            echo ("----------- Fin ------------<br>");
            */
        }
        /*
        echo "------------ IGENERAL ----------<br>\n";
        var_dump($this->productosIGeneral);
        echo "------------ SUBTITULO ----------<br>\n";
        var_dump($this->productosSubtitulo);
        echo "------------ DESC LARGA ----------<br>\n";
        var_dump($this->productosDescLarga);
        echo "------------ IMAGENES ----------<br>\n";
        var_dump($this->productosImagenes);
        echo "------------ CATA ----------<br>\n";
        var_dump($this->productosCata);
        echo "------------ CARACTERISTICAS ----------<br>\n";
        var_dump($this->productosCaracteristicas);
        echo "------------ REFERENCIAS ----------<br>\n";
        var_dump($this->productosReferencias);
        echo ("----------- Fin ------------<br>");
        */
    }
    public function writeCsv(){
        $contadorCategoria         = 0;
        $contadorPagina            = 0;
        $contadorProducto          = 0;
        $indiceActual              = count($this->productosUrl[$contadorCategoria]);
        $output = fopen('products.csv', 'w');
        $vectorProductosLabel = array(
            "ID",
            "Active",
            "Name",
            "Categories",
            "Price",
            "Tax",
            "Wholesale price",
            "OnSale",
            "Discount",
            "DiscountPercent",
            "DiscountFrom",
            "DiscountTo",
            "Reference",
            "SupplierReference",
            "Supplier",
            "Manufacturer",
            "Ean13",
            "Upc",
            "Ecotax",
            "Width",
            "Height",
            "Depth",
            "Weight",
            "Quantity",
            "MinimalQuantity",
            "Visibility",
            "AdditionalShippingCost",
            "Unity",
            "UnityPrice",
            "ShortDescription",
            "Description",
            "Tags",
            "Metatitle",
            "MetaKeywords",
            "MetaDescription",
            "UrlRewritten",
            "TextStock",
            "TextBackorder",
            "Avaiable",
            "ProductAvaiableDate",
            "ProductCreationDate",
            "ShowPrice",
            "ImageUrls",
            "DeleteExistingImages",
            "Feature",
            "AvaiableOnline",
            "Condition",
            "Customizable",
            "Uploadable",
            "TextFields",
            "OutStock",
            "IdNameShop",
            "AdvancedStockManagement",
            "DependsOnStock",
            "Warehouse"
        );
        $vectorProductos = array();
        array_push($vectorProductos,$vectorProductosLabel);
        foreach($this->productosIds as $id){
            foreach($id as $identificador) {
                if ($contadorPagina == $indiceActual) {
                    $contadorCategoria++;
                    $indiceActual += count($this->productosUrl[$contadorCategoria]);
                    $contadorProducto = 0;
                }
                $contadorPagina++;
                $precio = substr($this->productosPrecio[$contadorCategoria][$contadorProducto],0,strlen($this->productosPrecio[$contadorCategoria][$contadorProducto])-3);
                $informacionGeneralTemp = str_replace('Información general',' ',$this->productosIGeneral[$contadorCategoria][$contadorProducto]);
                $meta = str_replace(' ', '-', $this->productosTitulo[$contadorCategoria][$contadorProducto]);
                $csvName       = $this->productosTitulo[$contadorCategoria][$contadorProducto];
                $csvCategoria  = $contadorCategoria+3;
                $csvReferencia = $this->productosReferencias[$contadorCategoria][$contadorProducto];
                $csvDescCorta  = $this->productosDescLarga[$contadorCategoria][$contadorProducto];
                $csvImagen     = $this->productosImagenes[$contadorCategoria][$contadorProducto];
                $csvDescLarga  = $this->productosIGeneral[$contadorCategoria][$contadorProducto];
                $csvMeta       = $meta;
                $caracteristicasString = "";
                foreach($this->productosCaracteristicas[$contadorCategoria][$contadorProducto] as $keycarac => $carac){
                    $caracSinPuntos = str_replace(":",",",$carac);
                    $caracSinPuntos = str_replace(","," ",$caracSinPuntos);
                    $caracSinPuntos = strip_tags($caracSinPuntos);
                    //echo $this->caracteristicasDefault[$keycarac]. " ".$caracSinPuntos;
                    $caracteristicasString.= $this->caracteristicasDefault[$keycarac].":".$caracSinPuntos. ",";
                }
                //"Tipo de Vino:Rosado Blanco,Bodega:Mi Bodega Ribera del Duero Blanco,Regiones:Andalucia Interior",
                //echo "<br><br>";
                //echo "Caracteristicas String: ".$caracteristicasString."<br>";
                $caracteristicasString = substr($caracteristicasString,0,strlen($caracteristicasString)-1);
                $numeroCategoria = $contadorCategoria+3;
                $stringCategoria = "2".",".$numeroCategoria;
                $vectorValores = array(
                    $contadorPagina,
                    1,
                    $csvName,
                    $stringCategoria,
                    $precio,
                    "31",
                    $precio,
                    "0",
                    "0",
                    "0",
                    "0",
                    "0",
                    $csvReferencia,
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "50",
                    "1",
                    "both",
                    "1",
                    "",
                    "",
                    $csvDescCorta,
                    $csvDescLarga,
                    $csvMeta,
                    $csvMeta,
                    $csvMeta,
                    $csvMeta,
                    "",
                    "",
                    "",
                    "1",
                    "",
                    "",
                    "1",
                    "$csvImagen",
                    "",
                    $caracteristicasString,
                    1,
                    "new",
                    "0",
                    "0",
                    "0",
                    "0",
                    "0",
                    "0",
                    "0",
                    "0"
                );
                array_push($vectorProductos,$vectorValores);
                $contadorProducto++;
            }
        }
        foreach ($vectorProductos as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
        echo ("------- Valores ------<br>");
        echo "----------- Urls ----------<br>";
        var_dump($this->productosUrl);
        /*
        echo "----------- Titulo ----------<br>";
        var_dump($this->productosTitulo);
        echo "----------- Desc Corta ----------<br>";
        var_dump($this->productosDesc);
        echo "----------- Precio ----------<br>";
        var_dump($this->productosPrecio);
        echo "----------- Productos Ids ----------<br>";
        var_dump($this->productosIds);
        echo "------------ IGENERAL ----------<br>\n";
        var_dump($this->productosIGeneral);
        echo "------------ SUBTITULO ----------<br>\n";
        var_dump($this->productosSubtitulo);
        echo "------------ DESC LARGA ----------<br>\n";
        var_dump($this->productosDescLarga);
        echo "------------ IMAGENES ----------<br>\n";
        var_dump($this->productosImagenes);
        echo "------------ CATA ----------<br>\n";
        var_dump($this->productosCata);
        echo "------------ CARACTERISTICAS ----------<br>\n";
        var_dump($this->productosCaracteristicas);
        echo "------------ REFERENCIAS ----------<br>\n";
        var_dump($this->productosReferencias);
        echo ("----------- Fin ------------<br>");
        echo "------- Valores ------<br>";
        */
    }
}
?>