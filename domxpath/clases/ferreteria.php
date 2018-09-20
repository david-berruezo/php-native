<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 10/09/2016
 * Time: 16:37
 */
namespace clases;
use clases\Multicurl;
use clases\Dom;
class Ferreteria extends Multicurl{
    // URL PRINCIPAL
    /*
    "http://localhost/php/php/domxpath/ficheros/ferreteria/index.html"
    "https://ferreteria.es/"
    "http://localhost/php/php/domxpath/ficheros/ferreteria/index_old.html"
    "https://ferreteria.es/"
    */
    private $home = array(
        "http://localhost/php/php/domxpath/ficheros/ferreteria/index_old.html"
    );
    private $urls = array();

    private $categoriasNameUrl        = array();

    public function __construct(){
        // Multi Curl
        parent::__construct($this->home);
        $this->setContentAndOptions();
        $content = $this->getContent();
        //echo $content[0];
        // Dom Object
        $this->dom = new Dom($content);
    }

    /*
      * Obtenemos categorias
      * y creamos el vector principal
      */

    public function getCategories()
    {
        $this->categoriasNameUrl = $this->dom->getCategoriesIndex();
    }


    /*
     * Obtenemos las Imagenes de las categorias
     */
    public function getImagesCategories(){
        // Multi Curl
        $this->setCategorias($this->categoriasNameUrl);
        $this->setContentCategorias();
        $content = $this->getContent();
        // Dom Object
        $this->dom->setVectorCategorias($content);
        $this->categoriasNameUrl = $this->dom->getListadoCategorias();
        var_dump($this->categoriasNameUrl);
    }

    /*
     * Escrbimos el csv de categorias
     */
    public function writeCsvCategorias(){
        // Fichero csv
        $output           = fopen('categoriasferreteria.csv', 'w');
        $vectorCategorias = array();
        $vector           = array('ID','Active (0/1)','Name *','Parent category','Root category (0/1)','Description','Meta title','Meta keywords','Meta description','URL rewritten','Image URL');
        array_push($vectorCategorias,$vector);
        foreach($this->categoriasNameUrl as $categorias){
            $vector = array($categorias["id"],"1",$categorias["name"],$categorias["parent"],"0",$categorias["name"],$categorias["name"],$categorias["name"],$categorias["name"]," "," ");
            array_push($vectorCategorias,$vector);
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    $vector = array($hijos["id"],"1",$hijos["name"],$hijos["parent"],"0",$hijos["name"],$hijos["name"],$hijos["name"],$hijos["name"]," ",$hijos["imagen"]);
                    array_push($vectorCategorias,$vector);
                    if (isset($hijos['nietos'])){
                        foreach($hijos['nietos'] as $nietos){
                            $vector = array($nietos["id"],"1",$nietos["name"],$nietos["parent"],"0",$nietos["name"],$nietos["name"],$nietos["name"],$nietos["name"]," ",$nietos["imagen"]);
                            array_push($vectorCategorias,$vector);
                        }
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
    }

    /*
     * Obtenemos el detalle del producto
     */
    public function getProductDetail(){
        //var_dump($this->categoriasNameUrl);
        $this->setCategorias($this->categoriasNameUrl);
        $this->getDetailProduct();
        $this->categoriasNameUrl = $this->getContent();
        $this->dom->setVectorCategorias($this->categoriasNameUrl);
        $this->categoriasNameUrl = $this->dom->getDetalleProducto();
        //var_dump($this->categoriasNameUrl);
    }

    /*
     * Escribimos csv Productos
     */
    public function writeCsvProductos(){
        $contadorProducto = 0;
        $contadorPadre    = 0;
        $contadorHijo     = 0;
        $contadorNieto    = 0;
        $output           = fopen('productsferreteria.csv', 'w');
        $vectorCsv        = array();
        array_push($vectorCsv,$this->csvProductoVector());
        foreach($this->categoriasNameUrl as $categorias) {
            if (isset($categorias["hijos"])) {
                foreach ($categorias["hijos"] as $hijos) {
                    if (isset($hijos["nietos"])) {
                        foreach ($hijos["nietos"] as $nietos) {
                            $vector = array();
                            foreach ($nietos["productos"] as $producto) {
                                $csvProducto = array_values($producto['producto']);
                                array_push($vectorCsv,$csvProducto);
                                //var_dump($producto['producto']);
                                $contadorProducto++;
                            }
                        }
                        $contadorProducto = 0;
                        $contadorNieto++;
                    }else{
                        foreach($hijos["productos"] as $producto){
                            $csvProducto = array_values($producto['producto']);
                            array_push($vectorCsv,$csvProducto);
                            //var_dump($producto['producto']);
                            $contadorProducto++;
                        }
                    }
                }
                $contadorHijo++;
            }
            $contadorPadre++;
        }
        foreach ($vectorCsv as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
    }

    public function csvProductoVector(){
        $vector = array(
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
        return $vector;
    }
}
?>