<?php
namespace clases;
use Dom;
use DOMXPath;
use DOMDocument;
class ObjetoTrajes{
    // Vectores datos
    private $nombresCategorias               = array();
    private $urlsCategorias                  = array();
    private $imagenesCategorias              = array();
    private $productos                       = array();
    // Vectores Content
    private $indexContent                    = array();
    private $productsContent                 = array();
    private $productsDetailContent           = array();

    /*
     * Constructor del objeto
     */
    public function __construct()
    {
        echo "creamos clase<br>";
    }


    /*
     * Guardar Index Content
     */
    public function setIndexContent($vectorContent){
        $this->indexContent        = $vectorContent;
        $this->setCategorias($vectorContent[0]);
        //var_dump($this->nombresCategorias);
        //var_dump($this->urlsCategorias);
    }

    /*
     * Convertimos la url
     */
    public function convertirUrl($url){
        $urlConvertida = str_replace("http://www.defursac.fr/","http://www.defursac.net/",$url);
        //$urlConvertida = str_replace("http://www.defursac.fr/","https://makeyoursuit-outlet-website-dev.wellbehavedsoftware.com/utils/www.defursac.fr/",$url);
        return $urlConvertida;
    }

    /*
     * Set categorias
     */
    public function setCategorias($content){
        $contadorLi     = 0;
        $contadorAnchor = 0;
        $dom            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "nav";
        $tag            = "ul";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                $atributoValue  = "active";
                $tag            = "li";
                $consulta       = "//".$tag."[@class='".$atributoValue."']";
                $lis            = $xpath->query($consulta,$element);
                foreach($lis as $li){
                    $ulList = $li->getElementsByTagName("ul");
                    if ($ulList->length > 0){
                        foreach($ulList as $ul){
                            foreach($ul->childNodes as $li){
                                if ($li->nodeName == "li"){
                                    if ($contadorLi > 0){
                                        //echo "Li: ".$li->nodeValue."<br>";
                                        array_push($this->nombresCategorias,$li->nodeValue);
                                    }
                                    foreach ($li->childNodes as $anchor){
                                        //var_dump($anchor);
                                        //echo "Anchor: ".$anchor->getAttribute("href")."<br>";
                                        if ($contadorAnchor > 0){
                                            $urlCategoria = $this->convertirUrl($anchor->getAttribute("href"));
                                            array_push($this->urlsCategorias,$urlCategoria);
                                        }
                                        $contadorAnchor++;
                                    }
                                $contadorLi++;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /*
     * Get Categories
     */
    public function getCategories(){
        //var_dump($this->urlsCategorias);
        return $this->urlsCategorias;
    }


    /*
     * Guardar Products Content
     */
    public function setProductContent($vectorContent){
        $this->productsContent = $vectorContent;
        $contador              = 0;
        $contadorProducto      = 1;
        $contadorDatos         = 0;
        $contadorCategoria     = 3;
        foreach($this->productsContent as $productos){
            //echo ($productos);
            $datos = $this->getTitleImagesPrice($productos,$contador);
            if ($contador == 0){
                $this->productos = array(
                   'id'          => array(),
                   'idCategoria' => array(),
                   'titulo'      => array(),
                   'imagenes'    => array(),
                   'precio'      => array(),
                   'url'         => array(),
                   'shortDesc'   => array(),
                   'desc'        => array()
                );
            }
            //var_dump($datos);
            foreach($datos['titulos'] as $titulo){
                array_push($this->productos["id"],$contadorProducto);
                array_push($this->productos["idCategoria"],$contadorCategoria);
                array_push($this->productos["titulo"],$titulo);
                array_push($this->productos["precio"],$datos['precios'][$contadorDatos]);
                array_push($this->productos["url"],$datos['urls'][$contadorDatos]);
                array_push($this->productos["shortDesc"],$datos['shortDesc'][$contadorDatos]);
                $contadorDatos++;
                $contadorProducto++;
                //var_dump($this->productos["titulo"]);
            }
            $imagenCategoria = $this->getImagenCategoria($productos);
            array_push($this->imagenesCategorias,$imagenCategoria);
            $contadorDatos = 0;
            $contador++;
            $contadorCategoria++;
        }
        //var_dump($this->productos);
    }

    /*
     * Get array produc contents
     * to call detail product
     */
    public function getProductContent(){
        return $this->productos;
    }


    /*
     * Guardar Products Content
     */
    public function setProductDetailContent($vectorContent){
        $this->productsDetailContent = $vectorContent;
        $contador       = 0;
        $contadorImagen = 0;
        foreach($this->productsDetailContent as $productos){
            $datos = $this->getDetailProduct($productos,$contador);
            $this->productos["imagenes"][$contador] = array();
            foreach($datos["imagenes"] as $imagen){
                array_push($this->productos["imagenes"][$contador],$imagen);
            }
            array_push($this->productos["desc"],$datos["desc"][0]);
            $contador++;
        }
        //var_dump($this->productos);
        $this->writeCategorias();
        $this->writeProductos();
    }

    /*
     * Escribimos las categorias
     */
    public function writeCategorias(){
        $contador            = 0;
        $contadorCategoria   = 3;
        $output              = fopen('categorias_import.csv', 'w');
        $vector              = array();
        array_push($vector,$this->getVectorLabelCategorias());
        foreach($this->nombresCategorias as $categoria){
            $id              = $contadorCategoria;
            $active          = 1;
            $nombre          = $categoria;
            $parent          = 2;
            $root            = 0;
            $description     = $categoria;
            $metatitulo      = $categoria;
            $matakeywords    = $categoria;
            $metadescription = $categoria;
            $urlrewritten    = $categoria;
            $imageurl        = $this->imagenesCategorias[$contadorCategoria];
            $vectorTemp      = array($id,$active,$nombre,$parent,$root,$description,$metatitulo,$matakeywords,$metadescription,$urlrewritten,$imageurl);
            array_push($vector,$vectorTemp);
            $contadorCategoria++;
        }
        foreach($vector as $field){
            fputcsv($output, $field,',');
        }
        fclose($output);
        //var_dump($this->nombresCategorias);
        echo "Generadas categorias<br>";
    }


    /*
     * Escribimos las productos
     */
    public function writeProductos(){
        $contadorProducto    = 0;
        $output              = fopen('products_import.csv', 'w');
        $vector              = array();
        array_push($vector,$this->getVectorLabelProductos());
        //var_dump($this->productos);
        foreach($this->productos["id"] as $producto){
            $imagenes = '';
            foreach($this->productos["imagenes"][$contadorProducto] as $imagen){
                $imagenes.= $imagen.';';
            }
            $imagenes = substr($imagenes,0,strlen($imagenes)-1);
            $vectorProductos = array(
                $producto,
                1,
                $this->productos["titulo"][$contadorProducto],
                $this->productos["idCategoria"][$contadorProducto],
                $this->productos["precio"][$contadorProducto],
                31,
                $this->productos["precio"][$contadorProducto],
                "",
                "",
                "",
                "",
                "",
                $producto,
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
                100,
                1,
                "both",
                "",
                "",
                "",
                $this->productos["shortDesc"][$contadorProducto],
                $this->productos["desc"][$contadorProducto],
                $this->productos["titulo"][$contadorProducto],
                $this->productos["titulo"][$contadorProducto],
                $this->productos["titulo"][$contadorProducto],
                $this->productos["shortDesc"][$contadorProducto],
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                $imagenes,
                "",
                "", // Caracteristicas
                1,
                "new",
                "0",
                "0",
                "0",
                "0",
                "1",
                "",
                "",
                ""
            );
            array_push($vector,$vectorProductos);
            $contadorProducto++;
        }
        foreach($vector as $field){
            fputcsv($output, $field,',');
        }
        fclose($output);
        //var_dump($this->productos);
        echo "Generados productos<br>";
    }



    /*
     * Label categorias
     */
    public function getVectorLabelCategorias()
    {
        $vectorCategoriasLabel = array(
            "ID",
            "Active (0/1)",
            "Name *",
            "Parent category",
            "Root category (0/1)",
            "Description",
            "Meta title",
            "Meta keywords",
            "Meta description",
            "URL rewritten",
            "Image URL"
        );
        return $vectorCategoriasLabel;
    }

    /*
     * Get Vector Label Productos
     */
    public function getVectorLabelProductos()
    {
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
        return $vectorProductosLabel;
    }

    /*
     * get Imagen categoria
     */
    public function getImagenCategoria($content){
        $dom                            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath                          = new DOMXPath($dom);
        $atributoValue                  = "banner";
        $tag                            = "aside";
        $consulta                       = "//".$tag."[@class='".$atributoValue."']";
        $elements                       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                $imagen = $element->getElementsByTagName("img");
                if ($imagen->length > 0){
                    foreach($imagen as $img){
                        $nombreImagen           = $img->getAttribute("src");
                        $nombreImagenRenombrada = $this->convertirUrl($nombreImagen);
                    }
                }
            }
        }
        return $nombreImagenRenombrada;
        //return $imagen;
    }

    /*
     * get title,images,price
     */
    public function getTitleImagesPrice($content,$contador){
        $datos          = array(
            'imagenes'  => array(),
            'titulos'   => array(),
            'precios'   => array(),
            'urls'      => array(),
            'shortDesc' => array()
         );
        $dom                            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath                          = new DOMXPath($dom);
        $atributoValue                  = "product";
        $tag                            = "a";
        $consulta                       = "//".$tag."[@class='".$atributoValue."']";
        $elements                       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                $direccionUrl   = $this->convertirUrl($element->getAttribute('href'));
                array_push($datos['urls'],$direccionUrl);
                $titulos        = $element->getElementsByTagName("h2");
                if ($titulos->length > 0){
                    foreach($titulos as $titulo){
                        $strongs    = $titulo->getElementsByTagName("strong");
                        $shortDescs = $titulo->getElementsByTagName("span");
                        if ($strongs->length > 0){
                            foreach($strongs as $strong){
                                //var_dump($strong);
                                array_push($datos['titulos'],$strong->textContent);
                            }
                        }
                        if ($shortDescs->length > 0){
                            foreach($shortDescs as $shortDesc){
                                //var_dump($strong);
                                array_push($datos['shortDesc'],$shortDesc->textContent);
                            }
                        }
                    }
                }
            }
        }
        $atributoValue  = "price";
        $tag            = "span";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $price){
                //var_dump($price);
                $precio = (string)$price->textContent;
                $precio = html_entity_decode($precio, ENT_QUOTES, "UTF-8");
                //echo "El precio es: ".$precio."<br>";
                $precio = substr($precio, 3);
                $precio = rtrim(ltrim($precio));
                //echo "El precio es: ".$precio."<br>";
                array_push($datos['precios'],$precio);
            }
        }
        return $datos;
    }

    /*
     * Product get Detail
     */
    public function getDetailProduct($content,$contador){
        $datos          = array(
            'imagenes'  => array(),
            'desc'      => array()
        );
        //$datos['imagenes'][$contador]   = array();
        $dom                            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath                          = new DOMXPath($dom);
        $atributoValue                  = "description";
        $tag                            = "div";
        $consulta                       = "//".$tag."[@class='".$atributoValue."']";
        $elements                       = $xpath->query($consulta);
        $desc                           = "";
        if ($elements->length > 0){
            foreach($elements as $element){
                $paragraphs = $element->getElementsByTagName("p");
                //var_dump($paragraphs);
                if ($paragraphs->length > 0){
                    foreach($paragraphs as $paragraph){
                        //var_dump($paragraph);
                        if ($paragraph->textContent != ""){
                            $desc.= $paragraph->textContent;
                        }
                    }
                }
            }
            //echo "La desc es: ".$desc."<br>";
            array_push($datos['desc'],$desc);
        }
        $xpath                          = new DOMXPath($dom);
        $atributoValue                  = "pictures";
        $tag                            = "div";
        $consulta                       = "//".$tag."[@class='".$atributoValue."']";
        $elements                       = $xpath->query($consulta);
        //var_dump($elements);
        if ($elements->length > 0){
            foreach($elements as $element){
                $anchors = $element->getElementsByTagName("a");
                if ($anchors->length > 0){
                    foreach($anchors as $anchor){
                        if ($anchor->hasAttribute("data-zoom-image")){
                            $imagen                 = $anchor->getAttribute("data-zoom-image");
                            $nombreImagenRenombrada = $this->convertirUrl($imagen);
                            //array_push($datos['imagenes'],$imagen);
                            array_push($datos['imagenes'],$nombreImagenRenombrada);
                            //echo "La imagen es: ".$imagen."<br>";
                        }

                    }
                }
            }
        }
        return $datos;
    }
}
?>