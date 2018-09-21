<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class Ferreteria Extends Multicurl
{
    // URL PRINCIPAL
    private $home = array(
        "https://ferreteria.es"
    );
    // CATEGORIAS
    private $categoriasNameUrl        = array();
    private $vectorIdCat              = array(); // Guardamos id categorias padre
    private $vectorNProductosIdCat    = array(); // Guardamos numero de productos por idCat
    private $vectorUrlsFormateadas    = array(); // Guardamos las url en formato una detras de otra
    // PRODUCTOS
    private $productoNombre           = array();
    private $productoFabricante       = array();
    private $productoUrl              = array();
    private $productoDescCorta        = array();
    private $productoDescLarga        = array();
    private $productoPrecio           = array();
    private $productoReferencia       = array();
    private $productoUrlFotos         = array();
    private $caracteristicas          = array();
    private $productoPrecioAntiguo    = array();
    private $caracteristicasDefault   = array(
        'Gastos Envío',
        'Acerca del Fabricante',
        'Garantía',
        'Otras características'
    );
    private $fabricantes              = array();
    // Objeto Dom
    private $dom;

    public function __construct()
    {
        // Multi Curl
        parent::__construct($this->home);
        $this->setContentAndOptions();
        $content = $this->getContent();
        // Dom Object
        $this->dom = new Dom($content);
     }

     /*
      * Obtenemos categorias
      * y escribimos en csv
      */
     public function getCategories($id){
         // Fichero csv
         $output           = fopen('categoriasferreteria.csv', 'w');
         $vectorCategorias = array();
         $vector           = array('ID','Active (0/1)','Name *','Parent category','Root category (0/1)','Description','Meta title','Meta keywords','Meta description','URL rewritten','Image URL');
         array_push($vectorCategorias,$vector);
         // Elementos 3 niveles
         $elementos     = $this->dom->getElementsById($id);
         $level0        = 0;
         $level1        = 0;
         $level2        = 0;
         // Csv
         $contadorPadre = 3;
         $contadorNieto = 0;
         $contadorCsv   = 3;
         foreach($elementos as $elemento) {
             foreach ($elemento->childNodes as $li) {
                 if ($li->nodeType == 1) {
                     $anchors = $li->getElementsByTagName('a');
                     $spans   = $li->getElementsByTagName('span');
                     $uls     = $li->getElementsByTagName('ul');
                     foreach ($anchors as $anchor) {
                         //if ($level0 < 5){
                             $mystring = $anchor->parentNode->getAttribute("class");
                             $findmeLevel0 = 'level0';
                             $posLevel0 = strpos($mystring, $findmeLevel0);
                             if ($posLevel0 !== false) {
                                 $this->categoriasNameUrl[$level0] = array();
                                 $this->categoriasNameUrl[$level0]["name"]   = rtrim(ltrim($anchor->nodeValue));
                                 $this->categoriasNameUrl[$level0]["url"]    = $anchor->getAttribute("href");
                                 $this->categoriasNameUrl[$level0]["parent"] = 2;
                                 $this->categoriasNameUrl[$level0]["content"]= array();
                                 $this->categoriasNameUrl[$level0]["hijos"]  = array();
                                 $level0++;
                                 // Csv
                                 $name   = rtrim(ltrim($anchor->nodeValue));
                                 $vector = array($contadorCsv,"1","$name","2","0","$name","$name","$name","$name"," "," ");
                                 array_push($vectorCategorias,$vector);
                                 $contadorCsv++;
                                 $contadorPadre  = $contadorCsv;
                                 echo "name padre: ".rtrim(ltrim($anchor->nodeValue))."<br>";
                                 echo "url padre: ".$anchor->getAttribute("href")."<br>";
                             } else {
                                 $findmeLevel1 = 'level1';
                                 $posLevel1 = strpos($mystring, $findmeLevel1);
                                 if ($posLevel1 !== false) {
                                     $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["url"]    = $anchor->getAttribute("href");
                                     $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["name"]   = rtrim(ltrim($anchor->nodeValue));
                                     $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["parent"] = ($contadorPadre-1);
                                     $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["content"]= array();
                                     if (isset($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]) && !is_array($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1])) {
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1] = array();
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1]["nietos"] = array();
                                     }
                                     // Csv
                                     $name   = rtrim(ltrim($anchor->nodeValue));
                                     $parent = (int)($contadorPadre-1);
                                     $vector = array($contadorCsv,"1","$name","$parent","0","$name","$name","$name","$name"," "," ");
                                     array_push($vectorCategorias,$vector);
                                     array_push($this->vectorIdCat,((int)$parent));
                                     //array_push($this->vectorUrlsFormateadas,rtrim(ltrim($anchor->nodeValue)));
                                     $level1++;
                                     $contadorCsv++;
                                     $contadorNieto = $contadorCsv;
                                     echo "name hijo: ".rtrim(ltrim($anchor->nodeValue))."<br>";
                                     echo "url hijo: ".$anchor->getAttribute("href")."<br>";
                                 } else {
                                     $findmeLevel2 = 'level2';
                                     $posLevel2 = strpos($mystring, $findmeLevel2);
                                     if ($posLevel2 !== false) {
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["url"]    = $anchor->getAttribute("href");
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"]   = rtrim(ltrim($anchor->nodeValue));
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["parent"] = (int)($contadorNieto-1);
                                         $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["content"]= array();
                                         if (isset($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]) && !is_array($this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2])) {
                                             $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2] = array();
                                         }
                                         $name          = $this->categoriasNameUrl[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"];
                                         $parent        = (int)($contadorNieto-1);
                                         $vector        = array($contadorCsv,"1","$name","$parent","0","$name","$name","$name","$name"," "," ");
                                         array_push($vectorCategorias,$vector);
                                         array_push($this->vectorIdCat,((int)$parent));
                                         array_push($this->vectorUrlsFormateadas,$anchor->getAttribute("href"));
                                         $level2++;
                                         $contadorCsv++;
                                         echo "name nieto: ".rtrim(ltrim($anchor->nodeValue))."<br>";
                                         echo "url nieto: ".$anchor->getAttribute("href")."<br>";
                                     }else {
                                         array_push($this->vectorUrlsFormateadas, $anchor->getAttribute("href"));
                                     }
                                 }
                             }

                         //}
                     }
                 }
             }
         }
         // Escribimos el csv
         foreach ($vectorCategorias as $campo) {
             fputcsv($output, $campo,';');
         }
         // Cogemos las urls solo hijos
         fclose($output);
         //var_dump($this->categoriasNameUrl);
         //var_dump($this->vectorIdCat);
         //var_dump($this->vectorUrlsFormateadas);
         echo "Total de categorias: ".($contadorCsv-3)."<br>";
     }

    public function getImagesCategories(){
        // Csv
        $contadorPadre    = 3;
        $contadorNieto    = 0;
        $contadorCsv      = 3;
        //$output           = fopen('categoriasferreteria.csv', 'w');
        //$vectorCsv        = array();
        //$vector           = array('ID','Active (0/1)','Name *','Parent category','Root category (0/1)','Description','Meta title','Meta keywords','Meta description','URL rewritten','Image URL');
        /*
        $vectorPadres     = array();
        array_push($vectorCsv,$vector);
        foreach($this->categoriasNameUrl as $categorias){
            array_push($vectorPadres,$this->categoriasNameUrl["url"]);
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){

                        }
                    }else{

                    }
                }
            }
        }
        */

        // Multi Curl
        $this->setCategorias($this->categoriasNameUrl);
        $this->setContentCategorias();
        $content = $this->getContent();
        //var_dump($content);
        // Dom Object
        $this->dom = new Dom($content);
        $imagenesCategorias = $this->dom->getListadoCategoriasImagenes();
        //var_dump($imagenesCategorias);


        /*
        $imagenesVector = $this->dom->getListadoCategoriasImagenes();
        foreach($imagenesVector as $imagen){
            echo "imagen: ".$imagen."<br>";
        }
        */

        /*
        foreach($this->categoriasNameUrl as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                   if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){

                        }
                   }
                }
            }
        }
        */
        // Escribimos el csv
        /*
        foreach ($vectorCategorias as $campo) {
            fputcsv($output, $campo,';');
        }
        // Cogemos las urls solo hijos
        fclose($output);
        */
    }

     /*
      * Obtenemos los listados de los
      * productos y capturamos los ids de cada producto segun
      * nuestro cms
      */
     public function getProductList(){
         // Multi Curl
         parent::__construct($this->vectorUrlsFormateadas);
         $this->setContentAndOptions();
         $content = $this->getContent();
         // Dom Object
         $this->dom = new Dom($content);
         $tag   = "p";
         $class = "amount";
         $vectorNumeroItems = $this->dom->getElementsByTagClassNameOther($tag,$class);
         $vectorItems       = $this->dom->getElementsByTagClassNameOther("li","item");
         foreach($vectorNumeroItems as $numeroItems){
            if ($numeroItems->length > 0){
                $numero   = rtrim(ltrim($numeroItems->item(0)->nodeValue));
                $findme   = 'totales';
                $pos = strpos($numero, $findme);
                if ($pos === false) {
                    $numero = str_replace("Artículo(s)"," ",$numero);
                    $numero = rtrim(ltrim($numero));
                } else {
                    $vector = explode(" ",$numero);
                    $numero = rtrim(ltrim($vector[3]));
                    //echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
                    //echo " y existe en la posición $pos";
                }
                //echo "<br>Número de productos: ".$numero."<br>";
                array_push($this->vectorNProductosIdCat,$numero);
            }
         }

         foreach($vectorItems as $items){
            foreach($items as $item){
                $nombresProductos = $item->getElementsByTagName("h2");
                $divsProductos    = $item->getElementsByTagName("div");
                if ($nombresProductos->length > 0){
                    //$nombreProducto = $nombresProductos->item(0)->nodeValue;
                    $urlProducto    = $nombresProductos->item(0)->firstChild->getAttribute("href");
                    //array_push($this->productoNombre,$nombreProducto);
                    array_push($this->productoUrl,$urlProducto);
                    //echo ("urlProducto: ".$urlProducto."<br>");
                    //echo ("nombrePdocuto: ".$nombreProducto."<br>");
                }
            }
         }

         // Desc corta
         $vectorElementos = $this->dom->getDescCorta();
         foreach($vectorElementos as $elemento){
            array_push($this->productoDescCorta,$elemento);
         }
         var_dump($this->productoUrl);
         var_dump($this->vectorNProductosIdCat);
         var_dump($this->productoDescCorta);

     }

    /*
     * Obtenemos el detalle
     * del producto
     */
    public function getDetailProduct(){
        // Multi Curl
        //var_dump($this->productoUrl);
        parent::__construct($this->productoUrl);
        $this->setContentAndOptions();
        $content = $this->getContent();
        //var_dump($content);
        // Dom Object
        $this->dom   = new Dom($content);
        // Referencias
        $tag                  = "div";
        $class                = "product-name";
        $referenciasVector    = $this->dom->getElementsByTagClassNameOther($tag,$class);
        $contador = 0;
        $contadorProductos = 1;
        foreach($referenciasVector as $referencias){
            foreach($referencias as $referencia){
                if ($contador == 1){
                    //echo "referencia: ".rtrim(ltrim($referencia->nodeValue))."<br>";
                    //array_push($this->productoReferencia,rtrim(ltrim($referencia->nodeValue)));
                    array_push($this->productoReferencia,$contadorProductos);
                    $contadorProductos++;
                }
                $contador++;
            }
            $contador = 0;
        }

        // Name and Reference
        $vectorNameAndReference = $this->dom->getNameAndReference();
        foreach($vectorNameAndReference["name"] as $name){
            array_push($this->productoNombre,$name);
        }
        foreach($vectorNameAndReference["reference"] as $reference){
            array_push($this->productoReferencia,$reference);
        }

        // Price and Old price
        $vectorOldPriceAndPrice = $this->dom->getPriceAndOldPrice();
        foreach($vectorOldPriceAndPrice["oldprice"] as $old){
             array_push($this->productoPrecioAntiguo,$old);
        }
        foreach($vectorOldPriceAndPrice["price"] as $precio){
            array_push($this->productoPrecio,$precio);
        }

       // Images
       $this->productoUrlFotos = $this->dom->getImages();

       // Caracteristicas
        $caracteristicas        = $this->dom->getCaracteristicas();
        $encontrado             = FALSE;
        $contador               = 0;
        $contadorCarac          = 0;
        //"td" => array(), valores
        //"th" => array(), nombre
        //var_dump($caracteristicas);
        foreach($caracteristicas as $caracteristica){
            foreach($caracteristica["th"] as $caracteristicaNombre){
                foreach($this->caracteristicasDefault as $caracDefault){
                    $caracteristicaNombre = rtrim(ltrim($caracteristicaNombre));
                    if ($caracteristicaNombre == $caracDefault){
                        //echo "Encontrado<br>";
                        $encontrado = TRUE;
                    }
                }
                if ($encontrado == FALSE){
                    //echo "No Encontrado<br>";
                    array_push($this->caracteristicasDefault,$caracteristicaNombre);
                }
            }
            $contador++;
        }

        $contador = 0;
        //echo "<br><br>";
        //var_dump($caracteristicas);
        foreach($caracteristicas as $caracteristica){
            $caracteristicaString   = "";
            foreach($caracteristica["td"] as $caracValue) {
                //echo "hola desc carac: ".$caracteristicas[$contador]["th"][$contadorCarac]."<br><br>";
                if ($caracteristicas[$contador]["th"][$contadorCarac] == "Descripción"){
                    //echo ("descripcion".$caracValue."<br><br>");
                    array_push($this->productoDescLarga,$caracValue);
                }else if ($caracteristicas[$contador]["th"][$contadorCarac] != "Marca") {
                    $caracTemp = $caracValue;
                    $caracMod  = str_replace(","," ",$caracTemp);
                    $caracMod  = str_replace(":"," ",$caracMod);
                    $caracMod  = mb_strimwidth($caracMod,0,255,'...','utf-8');
                    $caracteristicaString.= $caracteristicas[$contador]["th"][$contadorCarac].":".$caracMod.",";
                }
                $contadorCarac++;
            }
            $caracteristicaString = substr($caracteristicaString,0,strlen($caracteristicaString)-1);
            //echo ("String caracteristica es: ".$caracteristicaString."<br><br>");
            array_push($this->caracteristicas,$caracteristicaString);
            echo ("Contador: ".$contador."contadorCarac: ".$contadorCarac."<br>");
            $contadorCarac = 0;
            $contador++;
        }
    }

    /*
     * Escribimos csv para
     * guardar nuestros productos
     */
    public function writeProductToCsv(){
        $output = fopen('productsferreteria.csv', 'w');
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
        $contadorIdCat               = 0;
        $contadorProductos           = 0;
        $contadorProductosCategorias = 0;
        foreach($this->productoNombre as $producto){
            echo "<br><br>";
            echo "----------- PRODUCTO ---------<BR>";
            if ($this->vectorNProductosIdCat[$contadorIdCat] == $contadorProductosCategorias){
                $contadorProductosCategorias = 0;
                $contadorIdCat++;
            }
            $parent = $this->vectorIdCat[$contadorIdCat];

            echo "Nombre producto: ".$producto."<br>";
            echo "Categoria Parent: ".$parent."<br>";
            echo "Referencia: ".$this->productoReferencia[$contadorProductos]."<br>";
            echo "Precio: ".$this->productoPrecio[$contadorProductos]."<br>";
            echo "Precio Antiguo: ".$this->productoPrecioAntiguo[$contadorProductos]."<br>";
            echo "Marca: ".$this->productoFabricante[$contadorProductos]."<br>";
            echo "Url: ".$this->productoUrl[$contadorProductos]."<br>";
            echo "DescCorta: ".$this->productoDescCorta[$contadorProductos]."<br><br>";
            echo "fotos<br>";
            $fotoString = "";
            foreach($this->productoUrlFotos[$contadorProductos]["hijos"] as $foto){
                echo "foto url: ".$foto."<br>";
                $fotoString.= $foto. ",";
            }
            $fotoString = substr($fotoString,0,strlen($fotoString)-1);
            echo "<br>";
            echo "Foto String: ".$fotoString."<br>";
            echo "Descripcion larga: ".$this->productoDescLarga[$contadorProductos]."<br>";
            echo "<br>";
            foreach($this->caracteristicasDefault as $caracteristica){
                echo "caracteristica default: ".$caracteristica."<br>";
            }
            echo "<br>";
            echo "caracteristica: ".$this->caracteristicas[$contadorProductos]."<br>";
            echo "<br><br>";

            $contadorTemp = $contadorProductos + 1;
            $vectorValores = array(
                $contadorTemp,
                1,
                rtrim(ltrim($producto)),
                $parent,
                rtrim(ltrim($this->productoPrecio[$contadorProductos])),
                "31",
                rtrim(ltrim($this->productoPrecio[$contadorProductos])),
                "0",
                "0",
                "0",
                "0",
                "0",
                rtrim(ltrim($this->productoReferencia[$contadorProductos])),
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
                rtrim(ltrim($this->productoDescCorta[$contadorProductos])),
                rtrim(ltrim($this->productoDescLarga[$contadorProductos])),
                rtrim(ltrim($producto)),
                rtrim(ltrim($producto)),
                rtrim(ltrim($producto)),
                rtrim(ltrim($producto)),
                "",
                "",
                "",
                "1",
                "",
                "",
                "1",
                "$fotoString",
                "",
                rtrim(ltrim($this->caracteristicas[$contadorProductos])),
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
            //echo "caracteristicas: ".$this->caracteristicas[$contadorProductos]."<br>";
            array_push($vectorProductos,$vectorValores);
            $contadorProductosCategorias++;
            $contadorProductos++;
            //echo "--------- Fin de Producto ---------<br><br><br>";
        }
        foreach ($vectorProductos as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
        //var_dump($this->vectorIdCat);
        //var_dump($this->categoriasNameUrl);
        /*
        var_dump($this->productoNombre);
        var_dump($this->productoReferencia);
        var_dump($this->productoPrecio);
        var_dump($this->productoUrl);
        var_dump($this->productoUrlFotos);
        var_dump($this->productoFabricante);
        var_dump($this->productoDescCorta);
        var_dump($this->productoDescLarga);
        var_dump($this->caracteristicas);
        */
        /*
        foreach($this->caracteristicasDefault as $caracteristica){
            echo "Caracteristica: ".$caracteristica."<br>";
        }
        */
    }
}
?>