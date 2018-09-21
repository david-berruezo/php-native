<?php
require_once "../vendor/autoload.php";
ini_set('display_errors', '1');

class VinoSeleccion extends Vino{
    // Product
    private $productName                    = array();
    private $productDescription             = array();
    private $productDescriptionLarge        = array();
    private $productImages                  = array();
    private $productPrice                   = array();
    private $productLinks                   = array();
    private $productCaracteristicas         = array();
    private $productInformacionGeneral      = array();
    private $productNotasDeCata             = array();
    private $productCategorias              = "";
    // Paginas de los productos
    private $numeroPaginas                  = "";
    // Csv array fields
    private $csvfields                      = "";
    private $categorias                     = array(
        "Rioja"            => "http://www.vinoseleccion.com/regiones/rioja",
        "Ribera del Duero" => "http://www.vinoseleccion.com/regiones/ribera-del-duero",
        "Toro"             => "http://www.vinoseleccion.com/regiones/toro",
        "Rias Baixas"      => "http://www.vinoseleccion.com/regiones/rias-baixas"
    );

    public function __construct($url)
    {
        parent::__construct($url);
    }
    public function setProductCategorias($categorias){
        $this->categorias = $categorias;
    }
    public function getLinks(){
        return $this->productLinks;
    }
    public function printLinks(){
        $link = $this->getLinks();
        //print the result
        echo "<table width=\"100%\" border=\"1\">
      <tr>
        <td width=\"30%\"><div align=\"center\"><b>Link Text </b></div></td>
        <td width=\"30%\"><div align=\"center\"><b>Link</b></div></td>
        <td width=\"40%\"><div align=\"center\"><b>Text with Link</b> </div></td>
      </tr>";
            for($i=0;$i<sizeof($link['link']);$i++)
            {
                echo "<tr>
                        <td><div align=\"center\">".$link['text'][$i]."</div></td>
                        <td><div align=\"center\">".$link['link'][$i]."</div></td>
                        <td><div align=\"center\"><a href=\"".$link['link'][$i]."\">".$link['text'][$i]."</a></div></td>
                    </tr>";
            }
            echo "</table>";
     }
     public function printImages(){
         $image = $this->getImages();
        //print the result
        echo "<table width=\"100%\" border=\"1\">
          <tr>
            <td width=\"30%\"><div align=\"center\"><b>Image</b></div></td>
            <td width=\"30%\"><div align=\"center\"><b>Link</b></div></td>
            <td width=\"40%\"><div align=\"center\"><b>Image Link</b> </div></td>
          </tr>";
             for($i=5;$i<sizeof($image['link'])-7;$i++)
             {
                 echo "<tr>
                <td><div align=\"center\"><img src=\"".$image['src'][$i]."\"/></div></td>";
                 if(($image['link'][$i])==null)
                 {
                     echo "<td width=\"30%\"><div align=\"center\">No Link</div></td>
                <td width=\"40%\"><div align=\"center\">No Link</div></td>
                </tr>";
             }else{
                 echo "<td><div align=\"center\">".$image['link'][$i]."</div></td>
                <td><div align=\"center\"><a href=\"".$image['link'][$i]."\">Go to link.</a></div></td>
                </tr>";
                 }
            }
             echo "</table>";
     }
    public function getProductNameAndUrl($tagname){
         $elementos = $this->getElementsByTagName($tagname);
         if ($elementos->length > 0){
             foreach($elementos as $elemento){
                 if ($elemento->getAttribute("class") == "product-name"){
                     echo "producto: ".$elemento->nodeValue."<br>\n";
                     array_push($this->productName,$elemento->nodeValue);
                     $anchors = $elemento->getElementsByTagName("a");
                     foreach($anchors as $anchor){
                        echo "url: ".$anchor->getAttribute("href")."<br>\n";
                        array_push($this->productLinks,$anchor->getAttribute("href"));
                     }
                 }
             }
         }
     }
     public function getProductDescripciones($classname)
     {
         $elementos = $this->getElementsByClassName($classname);
         if ($elementos->length > 0) {
             $descripcion = "";
             foreach ($elementos as $elemento) {
                 $anchors = $elemento->getElementsByTagName("a");
                 $desc    = "";
                 foreach ($anchors as $anchor){
                     $desc.= $anchor->nodeValue." ";
                 }
                 array_push($this->productDescription,$desc);
                 echo ("Descripcion: ".$desc."<br>");
             }
         }
         $elementos  = $this->getElementsByClassName("desc clearer");
         $vectorTemp = array();
         if ($elementos->length > 0) {
            foreach($elementos as $elemento){
               array_push($vectorTemp,$elemento->nodeValue);
               echo ("Descripcion 2 :".$elemento->nodeValue."<br>");
            }
         }
         for ($i=0;$i < count($this->productDescription);$i++){
            $this->productDescription[$i] = $this->productDescription[$i] . " " .$vectorTemp[$i] ;
         }
         foreach($this->productDescription as $description){
            echo("Description: ".$description."<br>\n");
         }
     }
     public function getPrice($classname){
         $elementos = $this->getElementsByClassName($classname);
         if ($elementos->length > 0) {
            foreach($elementos as $elemento){
                echo ("precio: ".$elemento->nodeValue."<br>\n");
                array_push($this->productPrice,$elemento->nodeValue);
            }
         }
     }
     public function construirOtroObjetoPadre($url){
         parent::__construct($url);
     }
     public function getProductDescripcionesLarge($classname)
     {
         $elementos = $this->getElementsByClassName($classname);
         if ($elementos->length > 0) {
             foreach ($elementos as $elemento) {
                echo ("Descripcion larga: ".$elemento->nodeValue."<br>\n");
                array_push($this->productDescriptionLarge,$elemento->nodeValue);
             }
         }
     }
     public function getCaracteristicas($classname){
         $elementos = $this->getElementsByClassName($classname);
         $contador  = 0;
         if ($elementos->length > 0) {
             foreach ($elementos as $elemento) {
                 $li = $elemento->getElementsByTagName("li");
                 if ($li->length > 0) {
                     foreach ($li as $ele) {
                        $tituloCaracteristica    = explode(":",$ele->nodeValue);
                        //var_dump($tituloCaracteristica);
                        $contenidoCaracteristica = $tituloCaracteristica[1];
                        $tituloCaracteristica    = $tituloCaracteristica[0];
                        echo ($tituloCaracteristica." :".$contenidoCaracteristica."<br>\n");
                        $this->productCaracteristicas[$contador][$tituloCaracteristica] = $contenidoCaracteristica;
                     }
                 }
             }
         }
     }
     public function getInformacionAndNotas($classname){
        $elementos = $this->getElementsByClassName($classname);
        $contador  = 0;
        $textos    = "";
        if ($elementos->length > 0) {
            foreach ($elementos as $elemento) {
                $divs = $elemento->getElementsByTagName("div");
                foreach ($divs as $div) {
                    //var_dump($div);
                    if ($div->getAttribute("class") == "content"){
                        if ($contador == 0){
                            $textos = $div->nodeValue;
                            $textos = str_replace('Información general', '', $textos);
                            echo "Informacion general: ".$textos."<br><br><br>";
                            array_push($this->productInformacionGeneral,$textos);
                        }else{
                            $textos = $div->nodeValue;
                            $textos = str_replace('Notas de cata', '', $textos);
                            echo "Notas de cata: ".$textos."<br><br><br>";
                            array_push($this->productNotasDeCata,$textos);
                        }
                        $contador++;
                    }
                }
            }
        }
     }
     public function getImagenes($classname)
     {
         $elementos = $this->getElementsByClassName($classname);
         $contador  = 0;
         if ($elementos->length > 0) {
             foreach ($elementos as $elemento) {
                $a = $elemento->getElementsByTagName("a");
                 if ($a->length > 0) {
                   foreach($a as $foto){
                     if ($contador == 0){
                         $foto = $foto->getAttribute("href");
                         array_push($this->productImages,$foto);
                         echo ("La imagen esta en : ".$foto. "<br>\n");
                     }
                     $contador++;
                   }
                 }
             }
         }
     }
     public function getPaginas($classname){
         $elementos = $this->getElementsByClassName($classname);
         $contador  = 0;
         if ($elementos->length > 0) {
             foreach ($elementos as $elemento) {
                 $li = $elemento->getElementsByTagName("li");
                 $this->numeroPaginas = $li->length - 1;
                 echo ("El numero de paginas son: ".$this->numeroPaginas."<br>\n");
             }
         }
     }

     public function llenarCsv(){
       $this->csvfields = array(
           "ID"=> "",
           "Active"=>"",
           "Name"=>"",
           "Categories"=>"",
           "Price"=>"",
           "Tax"=>"",
           "Wholesale price"=>"",
           "OnSale"=>"",
           "Discount"=>"",
           "DiscountPercent"=>"",
           "DiscountFrom"=>"",
           "DiscountTo"=>"",
           "Reference"=>"",
           "SupplierReference"=>"",
           "Supplier"=>"",
           "Manufacturer"=>"",
           "Ean13"=>"",
           "Upc"=>"",
           "Ecotax"=>"",
           "Width"=>"",
           "Height"=>"",
           "Depth"=>"",
           "Weight"=>"",
           "Quantity"=>"",
           "MinimalQuantity"=>"",
           "Visibility"=>"",
           "AdditionalShippingCost"=>"",
           "Unity"=>"",
           "UnityPrice"=>"",
           "ShortDescription"=>"",
           "Description"=>"",
           "Tags"=>"",
           "Metatitle"=>"",
           "MetaKeywords"=>"",
           "MetaDescription"=>"",
           "UrlRewritten"=>"",
           "TextStock"=>"",
           "TextBackorder"=>"",
           "Avaiable"=>"",
           "ProductAvaiableDate"=>"",
           "ProductCreationDate"=>"",
           "ShowPrice"=>"",
           "ImageUrls"=>"",
           "DeleteExistingImages"=>"",
           "DeleteExistingImages"=>"",
           "Feature"=>"",
           "AvaiableOnline"=>"",
           "AvaiableOnline"=>"",
           "Condition"=>"",
           "Customizable"=>"",
           "Customizable"=>"",
           "Uploadable"=>"",
           "TextFields"=>"",
           "TextFields"=>"",
           "OutStock"=>"",
           "IdNameShop"=>"",
           "AdvancedStockManagement"=>"",
           "DependsOnStock"=>"",
           "Warehouse"=>"",
       );
    }
}

class Pagina extends Vino{
    private $categorias = array(
        "http://www.vinoseleccion.com/regiones/rioja",
        "http://www.vinoseleccion.com/regiones/ribera-del-duero",
        "http://www.vinoseleccion.com/regiones/toro",
        "http://www.vinoseleccion.com/regiones/rias-baixas"
    );
    private $paginas = array();
    public function __construct()
    {
        parent::__construct($this->categorias);
        /*
        foreach($this->categorias as $categoria){
            parent::__construct($categoria);
            $this->getPaginas('pages');
            $numeroPaginas = $this->getPaginas('pages');
            $this->paginas[$categoria] = $numeroPaginas;
        }
        echo "numero paginas: ".$numeroPaginas."<br\n>";
        //$this->todo("li","item");
        //$this->getPagina();
        */
    }
    public function getCategorias(){
        return $this->paginas;
    }
    public function getPaginas($classname){
        $elementos     = $this->getElementsByClassName($classname);
        $numeroPaginas = 0;
        if ($elementos->length > 0){
            foreach($elementos as $child){
                $numeroPaginas = $child->textContent;
                $numeroPaginas = explode(":",$numeroPaginas);
                $numeroPaginas = ltrim(rtrim($numeroPaginas[1]));
                $numeroPaginas = substr($numeroPaginas,strlen($numeroPaginas)-1,strlen($numeroPaginas));
            }
        }
        return $numeroPaginas;
    }
    public function todo($tag,$class){
        $productos = $this->getElementsByClassNameTag($tag,$class);
        $contador  = 0;
        //var_dump($productos);
        echo ("Numero productos: ".$productos->length."<br>\n");
        if ($productos->length > 0) {
            echo "--------------- Todo -----------------<br>\n";
            foreach ($productos as $producto) {
                $hijos = $producto->childNodes;
                echo "--------------- Producto $contador  -----------------<br>\n";
                foreach($hijos as $hijo){
                    if ($hijo->tagName == "h2"){
                        echo "Nombre Producto: ".ltrim($hijo->textContent)."<br>\n";
                    }
                    if ($hijo->tagName == "a"){
                        $img = $hijo->childNodes[1];
                        echo "Url Producto: ".$hijo->getAttribute("href")."<br>\n";
                        array_push($this->paginas,$hijo->getAttribute("href"));
                        echo "Imagen Producto: ".$img->getAttribute("src")."<br>\n";
                    }
                    if ($hijo->tagName == "p"){
                        if ($hijo->getAttribute("class") == "sdesc clearer"){
                            echo "Descripcion Corta Producto: ".$hijo->textContent."<br>\n";
                        }else if ($hijo->getAttribute("class") == "desc clearer"){
                            echo "Descripcion Ampliada Producto: ".$hijo->textContent."<br>\n";
                        }
                    }
                    if ($hijo->tagName == "div"){
                        $nieto     = $hijo->firstChild;
                        $bisnieto  = $nieto->firstChild;
                        $hermano   = $bisnieto->nextSibling->nextSibling;
                        echo ("Precio: ".ltrim(rtrim($hermano->textContent))."<br>\n");
                    }
                    //var_dump($hijo);
                }
                echo "--------------- fin -----------------<br>\n";
                $contador++;
            }
            echo "--------------- fin -----------------<br>\n";
        }
    }
    public function getPagina(){
        //parent::__construct("detalle.html");
        $contador = 0;
        foreach($this->paginas as $pagina){
            parent::__construct($pagina);
            $this->getDetalle("div","product-view",$contador);
            $contador++;
        }
    }
    public function getDetalle($div,$class,$contador){
        $elementos = $this->getElementsByClassNameTagQuery($div,$class);
        foreach($elementos as $elemento){
            //var_dump($elemento);
            // product_view|product_essential|nodisplay--product_shop|product_name|h1--h2
            // product_view|product_essential|form|nodisplay--product_shop|product_name|h1--h2
            $form               = $elemento->firstChild->firstChild;
            if (isset($form) && $form->tagName == "form"){
                $productNameh2      = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->firstChild->nextSibling;
                $stdDescriptionP    = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->nextSibling->firstChild;
                //$generalFeatures    = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling;
                $generalFeatures    = $elemento->firstChild->firstChild->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
                $imagen             = $elemento->firstChild->firstChild->firstChild->nextSibling->nextSibling->firstChild->firstChild;
            }else{
                $productNameh2      = $elemento->firstChild->firstChild->nextSibling->firstChild->firstChild->nextSibling;
                $stdDescriptionP    = $elemento->firstChild->firstChild->nextSibling->firstChild->nextSibling->firstChild;
                //$generalFeatures    = $elemento->firstChild->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling;
                $generalFeatures    = $elemento->firstChild->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
                $imagen             = $elemento->firstChild->firstChild->nextSibling->nextSibling->firstChild->firstChild;
            }
            //var_dump($form);
            //var_dump($productNameh2);
            $informacionGeneral = $elemento->firstChild->nextSibling->firstChild;
            $notasDeCata        = $elemento->firstChild->nextSibling->firstChild->nextSibling;
            $informacionGeneral = $informacionGeneral->nodeValue;
            $notasDeCata        = $notasDeCata->nodeValue;
            $subtitulo          = $productNameh2->nodeValue;
            if ($stdDescriptionP){
                $descripcion        = $stdDescriptionP->nodeValue;
            }
            // Cuado hay descuento 35%
            if (property_exists($imagen, 'wholeText')){
                $imagen             = $elemento->firstChild->firstChild->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
            }
            $imagen             = $imagen->getAttribute("src");
            $caracteristicasTextoValue = $generalFeatures->childNodes;
            foreach($caracteristicasTextoValue as $li){
                $valor = explode(":",$li->nodeValue);
                echo $li->firstChild->nodeValue . " ".$valor[1]."<br>\n";
            }
            /*
            $caracSepearadas    = explode(":",$caracteristicas[1]);
            $tipoVino           = ltrim(rtrim(substr($caracSepearadas[0],0,strlen($caracSepearadas[0])-6)));
            $bodega             = ltrim(rtrim(substr($caracSepearadas[1],0,strlen($caracSepearadas[1])-8)));
            $regiones           = ltrim(rtrim(substr($caracSepearadas[2],0,strlen($caracSepearadas[2])-15)));
            $variedadUva        = ltrim(rtrim(substr($caracSepearadas[3],0,strlen($caracSepearadas[3])-8)));
            $enologo            = ltrim(rtrim(substr($caracSepearadas[4],0,strlen($caracSepearadas[4])-9)));
            $bodeguero          = ltrim(rtrim(substr($caracSepearadas[5],0,strlen($caracSepearadas[5])-15)));
            $tipoBarrica        = ltrim(rtrim(substr($caracSepearadas[6],0,strlen($caracSepearadas[6])-15)));
            $tipoBotella        = ltrim(rtrim(substr($caracSepearadas[7],0,strlen($caracSepearadas[7])-22)));
            $permanenciaBarrica = ltrim(rtrim(substr($caracSepearadas[8],0,strlen($caracSepearadas[8])-14)));
            $capacidad          = ltrim(rtrim(substr($caracSepearadas[9],0,strlen($caracSepearadas[9])-8)));
            $servicio           = ltrim(rtrim(substr($caracSepearadas[10],0,strlen($caracSepearadas[10]))));
            $graduacion         = ltrim(rtrim($caracSepearadas[11]));
            */
            //$pattern = "/[(Caracteristicas generales|Tipo de Vino|Regiones|Enólogo|Tipo de barrica|Permanencia en barrica|Servicio|Bodega|Veriedad de Uva|Bodeguero|Tipo de botella|Capacidad|Graduación)]/";
            //preg_match_all($pattern, $generalFeatures->nodeValue, $matches,1);
            //var_dump($matches);
            echo "----------- Datos $contador ----------<br>\n";
            echo "El subtitulo es: ".$subtitulo."<br>\n";
            //echo "La descripcion es: ".$descripcion."<br>\n";
            echo "La imagen es: ".$imagen."<br>\n";
            echo "<br>";
            echo "Notas de cata: ".$notasDeCata."<br>\n";
            echo "<br>";
            echo "Informacion: ".$informacionGeneral."<br>\n";
            echo "----------- Caracteristicas ----------<br>\n";
            /*
            echo "tipo de vino: ".$tipoVino."<br>\n";
            echo "boedega: ".$bodega."<br>\n";
            echo "regiones: ".$regiones."<br>\n";
            echo "variedadUva: ".$variedadUva."<br>\n";
            echo "enologo: ".$enologo."<br>\n";
            echo "bodeguero: ".$bodeguero."<br>\n";
            echo "tipoBarrica: ".$tipoBarrica."<br>\n";
            echo "tipoBotella: ".$tipoBotella."<br>\n";
            echo "permanenciaBarrica: ".$permanenciaBarrica."<br>\n";
            echo "capacidad: ".$capacidad."<br>\n";
            echo "servicio: ".$servicio."<br>\n";
            echo "graduacion: ".$graduacion."<br>\n";
            */
            echo "----------- Fin ----------<br>\n";
        }
    }
}
// Primer Paso categorias
// Segundo Paso numero de paginas por categoria
$categoria  = new Pagina();



$pagina = 0;
/*
foreach ($categorias as $categoria){
    $vinos = new Vino($categoria);
    $vinos->getProductNameAndUrl("h2");
    $vinos->getProductDescripciones("sdesc clearer");
    $vinos->getPrice("price");
    $vinos->getPaginas('pages');
    $links = $vinos->getLinks();
    foreach($links as $link){
        $vinos->construirOtroObjetoPadre($link);
        $vinos->getProductDescripcionesLarge('std description');
        $vinos->getCaracteristicas('general-features');
        $vinos->getInformacionAndNotas('product-collateral tabs');
        $vinos->getImages('product-img-box');
    }
}
*/

/*
// Pagina Listado
$vinos = new Vino('pagina.html');
//$vinos = new Vino('http://www.vinoseleccion.com/regiones/ribera-del-duero');
//$vinos->setProductCategorias("3,8");
//$vinos->printLinks();
//$vinos->printImages();
$vinos->getProductNameAndUrl("h2");
$vinos->getProductDescripciones("sdesc clearer");
$vinos->getPrice("price");
$vinos->getPaginas('pages');
// Pagina Detalle
//$links = $vinos->getLinks();
$vinos->construirOtroObjetoPadre('detalle.html');
//$vinos->construirOtroObjetoPadre('http://www.vinoseleccion.com/finca-resalso-2015');
$vinos->getProductDescripcionesLarge('std description');
$vinos->getCaracteristicas('general-features');
$vinos->getInformacionAndNotas('product-collateral tabs');
$vinos->getImagenes('product-img-box');
foreach($links as $link){
    //$vinos->construirOtroObjetoPadre('detalle.html');
    $vinos->construirOtroObjetoPadre($link);
    $vinos->getProductDescripcionesLarge('std description');
    $vinos->getCaracteristicas('general-features');
    $vinos->getInformacionAndNotas('product-collateral tabs');
    $vinos->getImages('product-img-box');
}
*/
?>

