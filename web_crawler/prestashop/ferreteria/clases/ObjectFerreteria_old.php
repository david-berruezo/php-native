<?php
namespace clases;
use DOMDocument;
use DOMXPath;
class ObjectFerreteria {
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

    /*
     * Constructor del objeto
     */
    public function __construct(){
        //libxml_use_internal_errors(true);
    }

    /*
     * Guardar Index Content
     */
    public function setIndexContent($vectorContent){
        $this->indexContent = $vectorContent;
        $cadena = $this->scrapeIndex($this->indexContent);
        $this->leerUrls($cadena);
        $this->queryMarcasIndex();
        //var_dump($this->vectorImagenesPrincipalesMarcas);
    }

    /*
     * Cortamos el set Index Content
     */
    public function scrapeIndex($contenidoVector){
        $inicio        = '<ul class="sf-menu" id="left-nav">';
        $final         = '<div class="widget widget-static-block home-banner-left">';
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
     * Guardamos Padre Content
     */
    public function setPadreContent($vectorContent){
        $vectorCadena       = $this->scrapePadresHijosNietos($vectorContent);
        $this->padreContent = $vectorCadena;
    }

    /*
     * Devolvemos el vector Padres
     */
    public function getPadres(){
        return $this->vectorUrlsPadres;
    }

    /*
     * Guardamos Hijo Content
     */
    public function setHijoContent($vectorContent){
        $vectorCadena      = $this->scrapePadresHijosNietos($vectorContent);
        $this->hijoContent = $vectorCadena;
    }

    /*
     * Devolvemos hijos url
     */
    public function getHijos(){
        return $this->vectorUrlsHijosBuenos;
    }


    /*
     * Guardamos Nieto Content
     * Y ya guardamos todos los datos
     * en guardar DATOS padre,hijo,nieto
     */
    public function setNietoContent($vectorContent){
        $cadenaContent      = $this->scrapePadresHijosNietos($vectorContent);
        $this->nietoContent = $cadenaContent;
        $this->guardarDatos();
    }

    /*
     * Devolvemos hijos url
     */
    public function getNietos(){
        return $this->vectorUrlsNietos;
    }

    /*
     * Cortamos el padre,hijos,nietos Content
     */
    public function scrapePadresHijosNietos($contenidoVector){
        $inicio        = '<div class="grid_18 push_6 grid_content">';
        $final         = '<div class="grid_6 pull_18">';
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
        foreach($contenidoVector as $contenido){
            $dom             = new DOMDocument();
            $dom->loadHTML("$contenido");
            //echo $contenido;
            $xpath           = new DOMXPath($dom);
            $elemento        = $dom->getElementById("left-nav");
            echo "--------------------- Urls Categorias, Subcategorias, Sub SubCategiruas  --------------<br>";
            $encontradoHijos = FALSE;
            $contadorHijo    = 0;
            $level0          = 0;
            $level1          = 0;
            $level2          = 0;
            $contadorCsv     = 3;
            foreach ($elemento->childNodes as $li) {
                if ($li->nodeType == 1) {
                    $anchors = $li->getElementsByTagName('a');
                    $uls     = $li->getElementsByTagName('ul');
                    foreach ($anchors as $anchor) {
                      //if ($level0 < 10) {
                          $nombreCat = rtrim(ltrim($anchor->nodeValue));
                          $mystring = $anchor->parentNode->getAttribute("class");
                          $findmeLevel0 = 'level0';
                          $posLevel0 = strpos($mystring, $findmeLevel0);
                          if ($posLevel0 !== false) {
                              $url = $anchor->getAttribute("href");
                              $urlConvertida = $this->convertirUrl($url);
                              array_push($this->vectorUrlsPadres, $urlConvertida);
                              $this->crearPadre($level0, $contadorCsv, $urlConvertida, $nombreCat);
                              $encontradoHijos = FALSE;
                              $level0++;
                              $level1 = 0;
                              $level2 = 0;
                              $contadorCsv++;
                              $contadorPadre = $contadorCsv;
                          } else {
                              $findmeLevel1 = 'level1';
                              $posLevel1 = strpos($mystring, $findmeLevel1);
                              if ($posLevel1 !== false) {
                                  $url = $anchor->getAttribute("href");
                                  $urlConvertida = $this->convertirUrl($url);
                                  array_push($this->vectorUrlsHijos, $urlConvertida);
                                  array_push($this->vectorUrlsHijosBuenos, $urlConvertida);
                                  $this->crearHijo($level0, $level1, $contadorPadre, $contadorCsv, $urlConvertida, $nombreCat);
                                  $contadorHijo++;
                                  $parent = (int)($contadorPadre - 1);
                                  $encontradoHijos = FALSE;
                                  $level1++;
                                  $level2 = 0;
                                  $contadorCsv++;
                                  $contadorNieto = $contadorCsv;
                              } else {
                                  $findmeLevel2 = 'level2';
                                  $posLevel2 = strpos($mystring, $findmeLevel2);
                                  if ($posLevel2 !== false) {
                                      $url = $anchor->getAttribute("href");
                                      $urlConvertida = $this->convertirUrl($url);
                                      array_push($this->vectorUrlsNietos, $urlConvertida);
                                      if (!$encontradoHijos) {
                                          $value = $this->vectorUrlsHijos[$contadorHijo - 1];
                                          array_push($this->vectorUrlsHijosNietos, $value);
                                          $encontradoHijos = TRUE;
                                          $this->updateHijosNoProductosHijoSiNietos($level0, $level1);
                                      }
                                      $this->crearNieto($level0, $level1, $level2, $contadorNieto, $contadorCsv, $urlConvertida, $nombreCat);
                                      $contadorCsv++;
                                      $level2++;
                                  }
                              }
                          //}
                      }
                    }
                }
            }
            echo "--------------------- Fin Categorias --------------<br>";
        }
        $this->contarHijosDePadresYNietosDeHijos();
        $this->normalizarVector();
        $this->printCategoriaPrincipal();
    }

    public function convertirUrl($url){
        $urlConvertida = str_replace("https://ferreteria.es/","http://www.ferreteria.net/",$url);
        return $urlConvertida;
    }

    public function crearPadre($level0,$contadorCsv,$url,$nombreCat){
        $this->categoriaPrincipal[$level0]                = array();
        $this->categoriaPrincipal[$level0]["id"]          = $contadorCsv;
        $this->categoriaPrincipal[$level0]["name"]        = $nombreCat;
        $this->categoriaPrincipal[$level0]["url"]         = $url;
        $this->categoriaPrincipal[$level0]["parent"]      = 2;
        $this->categoriaPrincipal[$level0]["imagen"]      = " "; //$this->vectorImagenesPadres[$level0];
        $this->categoriaPrincipal[$level0]["numeroHijos"] = "";
        $this->categoriaPrincipal[$level0]["descripcion"] = "";
        $this->categoriaPrincipal[$level0]["hijos"]       = array();
    }

    public function updateNumeroHijosPadre($level0,$numeroHijos){
        $this->categoriaPrincipal[$level0]["numeroHijos"] = $numeroHijos;
    }

    public function crearHijo($level0,$level1,$contadorPadre,$contadorCsv,$url,$nombreCat){
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["id"]              = $contadorCsv;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["url"]             = $url;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["name"]            = $nombreCat;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["parent"]          = ($contadorPadre-1);
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["imagen"]          = "";
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["descripcion"]     = "";
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["numeroProductos"] = 0;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1]["productos"]       = array();
    }

    public function updateHijosNoProductosHijoSiNietos($level0,$level1){
        unset($this->categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["productos"]);
        unset($this->categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["numeroProductos"]);
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["numeroNietos"]    = 0;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["nietos"]          = array();
    }

    public function crearNieto($level0,$level1,$level2,$contadorNieto,$contadorCsv,$url,$nombreCat){
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["id"]              = $contadorCsv;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["url"]             = $url;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"]            = $nombreCat;
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["parent"]          = (int)($contadorNieto-1);
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["imagen"]          = "";
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["descripcion"]     = "";
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["numeroProductos"] = "";
        $this->categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["productos"] = array();
    }

    public function contarHijosDePadresYNietosDeHijos(){
        $contadorPadre = 0;
        $contadorHijo  = 0;
        foreach($this->categoriaPrincipal as $padres){
            $this->categoriaPrincipal[$contadorPadre]["numeroHijos"] = count($this->categoriaPrincipal[$contadorPadre]["hijos"]);
            foreach($padres["hijos"] as $hijos){
                if (isset($hijos["nietos"])){
                    $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroNietos"] = count($this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"]);
                }
                $contadorHijo++;
            }
            $contadorHijo = 0;
            $contadorPadre++;
        }
    }

    public function normalizarVector(){
        $this->vectorUrlHijosSinNietos = array_diff($this->vectorUrlsHijos,$this->vectorUrlsHijosNietos);
        $vectorTemp                    = array();
        foreach($this->vectorUrlHijosSinNietos as $vUrlHijosSinNietos){
            array_push($vectorTemp,$vUrlHijosSinNietos);
        }
        $this->vectorUrlHijosSinNietos = $vectorTemp;
        $this->vectorUrlsHijos = array_diff($this->vectorUrlsHijos,$this->vectorUrlsHijosNietos);
    }

    public function printCategoriaPrincipal(){
        var_dump($this->categoriaPrincipal);
        echo "------------- Imagenes Padres --------<br>";
        /*
        var_dump($this->vectorImagenesPadres);
        echo "----------------------------------------<br>";
        echo "------------- Vector Descripcion Padre ---------------<br>";
        var_dump($this->vectorDescripcionPadre);
        echo "----------------------------------------<br>";
        */
        /*
        echo "------------- Padres --------<br>";
        var_dump($this->vectorUrlsPadres);
        echo "----------------------------------------<br>";
        echo "------------- Hijos todos --------<br>";
        var_dump($this->vectorUrlsHijos);
        echo "------------- Hijos Bueno --------<br>";
        var_dump($this->vectorUrlsHijosBuenos);
        echo "----------------------------------------<br>";
        echo "------------- Hijos Sin nietos --------<br>";
        var_dump($this->vectorUrlHijosSinNietos);
        echo "----------------------------------------<br>";
        echo "------------- Hijos Con nietos --------<br>";
        var_dump($this->vectorUrlsHijosNietos);
        echo "----------------------------------------<br>";
        echo "------------- Nietos --------<br>";
        var_dump($this->vectorUrlsNietos);
        echo "----------------------------------------<br>";
        */

        /*
        echo "------------- Imagenes Hijos ---------------<br>";
        var_dump($this->vectorHijosImagenes);
        echo "----------------------------------------<br>";
        echo "------------- Imagenes Principales Marcas ---------------<br>";
        var_dump($this->vectorImagenesPrincipalesMarcas);
        echo "----------------------------------------<br>";
        */
    }

    /*
     * Devolvemos categoria principal
     */
    public function getCategoriaPrincipal(){
        return $this->categoriaPrincipal;
    }

    /*
     * Devolvemos los productos
     */
    public function getProductosUrl(){
        return $this->vectorUrlsProductos;
    }

    /*
     * Guradar datos Padres,
     * Hijos y Nietos
     */
    public function guardarDatos(){
        $contadorPadre       = 0;
        $contadorHijo        = 0;
        $contadorNieto       = 0;
        $contadorHijoVector  = 0;
        $contadorPadreVector = 0;
        $contadorNietoVector = 0;
        $contadorProducto    = 1;
        $encontradoNieto     = FALSE;
        // Imagenes
        $vectorImagenesPadre = $this->getImagenesIndexCategorias();
        $this->queryMarcasPrincipales(1);$this->queryMarcasPrincipales(2);$this->queryMarcasPrincipales(3);
        // csv
        $output                = fopen('categories_import.csv', 'w');
        $vectorCategorias      = array();
        $vectorCategoriasLabel = $this->getVectorLabelCategorias();
        array_push($vectorCategorias,$vectorCategoriasLabel);
        foreach ($this->categoriaPrincipal as $padre){
            $vectorCsv     = $this->guardarPadre($contadorPadre,$vectorImagenesPadre[$contadorPadre],$this->padreContent[$contadorPadre]);
            $imagenesHijos = $this->listadoHijosNietosImagenes($this->padreContent[$contadorPadre]);
            // csv
            array_push($vectorCategorias,$vectorCsv);
            if (isset($padre["hijos"])) {
                foreach($padre["hijos"] as $hijo){
                    $vectorCsv      = $this->guardarHijo($contadorPadre,$contadorHijo,$imagenesHijos[$contadorHijo],$this->hijoContent[$contadorHijoVector]);
                    $imagenesNietos = $this->listadoHijosNietosImagenes($this->hijoContent[$contadorHijoVector]);
                    // csv
                    array_push($vectorCategorias,$vectorCsv);
                    if (isset($hijo["nietos"])) {
                        foreach($hijo["nietos"] as $nieto){
                            $vectorCsv = $this->guardarNieto($contadorPadre,$contadorHijo,$contadorNieto,$this->nietoContent[$contadorNietoVector],$imagenesNietos[$contadorNieto]);
                            $this->guardarProductoNieto($contadorPadre,$contadorHijo,$contadorNieto,$this->nietoContent[$contadorNietoVector],$contadorProducto);
                            $contadorProducto += $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["numeroProductos"];
                            // csv
                            array_push($vectorCategorias,$vectorCsv);
                            $contadorNieto++;
                            $contadorNietoVector++;
                        }
                        $contadorNieto = 0;
                    }else{
                        $this->guardarProductoHijo($contadorPadre,$contadorHijo,false,$this->hijoContent[$contadorHijoVector],$contadorProducto);
                        $contadorProducto += $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroProductos"];
                    }
                    $contadorHijo++;
                    $contadorHijoVector++;
                }
                $contadorHijo = 0;
            }
            $contadorPadre++;
        }
        foreach ($vectorCategorias as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
        $this->writeCsvMarcas();
    }


    public function guardarPadre($contadorPadre,$imagen,$contentPadre){
        $descripcionPadre                                          = $this->queryDescripcion($contentPadre);
        $this->categoriaPrincipal[$contadorPadre]["descripcion"]   = $descripcionPadre;
        $this->categoriaPrincipal[$contadorPadre]["imagen"]        = $imagen;
        $vectorCsv = array($this->categoriaPrincipal[$contadorPadre]["id"],1,$this->categoriaPrincipal[$contadorPadre]["name"],$this->categoriaPrincipal[$contadorPadre]["parent"],0,$this->categoriaPrincipal[$contadorPadre]["descripcion"],$this->categoriaPrincipal[$contadorPadre]["name"],$this->categoriaPrincipal[$contadorPadre]["name"],$this->categoriaPrincipal[$contadorPadre]["name"]," ",$this->categoriaPrincipal[$contadorPadre]["imagen"]);
        return $vectorCsv;
    }

    public function guardarHijo($contadorPadre,$contadorHijo,$imagen,$content){
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroProductos"] = $this->queryTotalesProductos($content);
        $descripcion = $this->queryDescripcion($content);
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["imagen"]      = $imagen;
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["descripcion"] = $descripcion;
        $vectorCsv = array($this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["id"],1,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["parent"],0,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["descripcion"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["name"]," ",$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["imagen"]);
        return $vectorCsv;
    }

    public function guardarNieto($contadorPadre,$contadorHijo,$contadorNieto,$content,$imagen){
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["numeroProductos"] = $this->queryTotalesProductos($content);
        $descripcion = $this->queryDescripcion($content);
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["descripcion"] = $descripcion;
        $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["imagen"] = $imagen;
        $vectorCsv = array($this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["id"],1,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["parent"],0,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["descripcion"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["name"],$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["name"]," ",$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["imagen"]);
        return $vectorCsv;
    }

    public function guardarProductoHijo($contadorPadre,$contadorHijo,$contadorNieto,$content,$contadorProducto){
        $descCorta = $this->queryDescCorta($content);
        $urlVector = $this->queryUrlProducto($content);
        for ($i = 0; $i < $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroProductos"];$i++){
            if (isset($descCorta[$i]) && isset($urlVector[$i])){
                $desc = $descCorta[$i];
                $url  = $urlVector[$i];
                $url  = $this->convertirUrl($url);
            }else{
                $desc = " ";
                $url  = " ";
            }
            //array_push($this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["productos"],$this->crearProducto( ($i+$contadorProducto), $desc,$url));
            array_push($this->productos,$this->crearProducto( ($i+$contadorProducto), $desc,$url,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["id"]));
        }
    }

    public function guardarProductoNieto($contadorPadre,$contadorHijo,$contadorNieto,$content,$contadorProducto){
        $descCorta = $this->queryDescCorta($content);
        $urlVector = $this->queryUrlProducto($content);
        for ($i = 0; $i < $this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["numeroProductos"];$i++){
            if (isset($descCorta[$i]) && isset($urlVector[$i]) ){
                $desc = $descCorta[$i];
                $url  = $urlVector[$i];
                $url  = $this->convertirUrl($url);
            }else{
                $desc = " ";
                $url  = " ";
            }
            //array_push($this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"],$this->crearProducto( ($i+$contadorProducto), $desc,$url ));
            array_push($this->productos,$this->crearProducto( ($i+$contadorProducto), $desc,$url,$this->categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["id"]));
        }
    }

    public function crearProducto($i,$desc,$url,$parent){
        $producto                        = array();
        $producto["ID"]                  = $i;
        $producto["parent"]              = $parent;
        $producto['Short description']   = $desc;
        //$producto["url"]               = $url;
        //$producto["Name"]              = "";
        //$producto["Reference"]         = $i;
        //$producto['Active']            = 1;
        //$producto['ImageUrls']         = "";
        //$producto['Wholesale price']   = "";
        //$producto['Price']             = "";
        //$producto['Feature']           = "";
        //$producto['Description']       = "";
        //$producto['Quantity']          = 100;
        //$producto['Manufacturer']      = "";
        //$producto['Tags']              = "";
        //$producto['IdNameShop']        = 1;
        array_push($this->vectorUrlsProductos,$url);
        return $producto;
    }

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
      * Escribimos csv categorias
      * marcas,productos
      */
    public function writeCsvMarcas(){
        $output            = fopen('manufacturers_import.csv', 'w');
        $contadorMarca     = 1;
        $vectorMarcas      = array();
        $vectorMarcasLabel = $this->getVectorLabelMarcas();
        array_push($vectorMarcas,$vectorMarcasLabel);
        foreach ($this->vectorImagenesPrincipalesMarcas as $key => $value){
            $vector = $this->writeCsvFieldsMarcas($contadorMarca,$key,$value);
            array_push($vectorMarcas,$vector);
            $contadorMarca++;
        }
        foreach ($vectorMarcas as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
    }

    public function getVectorLabelMarcas(){
        $vectorMarcasLabel = array(
            "ID",
            "Active (0/1)",
            "Name *",
            "Description",
            "Short description",
            "Meta title",
            "Meta keywords",
            "Meta description",
            "Image URL"
        );
        return $vectorMarcasLabel;
    }

    public function writeCsvFieldsMarcas($contadorMarca,$name,$imagen){
        $vector = array(
            $contadorMarca,
            1,
            $name,
            "descripción",
            "descripción corta",
            $name,
            $name,
            $name,
            $imagen,
        );
        return $vector;
    }

    /*
     * Obtenemos productos
     */
    public function getProducts(){
        return $this->vectorUrlsProductos;
    }

    /*
     * Guardamos Nieto Content
     */
    /*
    public function setProductoContent($vectorContent,$contadorProductos){
        $this->productoContent = $vectorContent;
        $this->updateProducts($contadorProductos);
    }
    */

    public function setProductoContent($vectorContent){
        $this->productoContent = $vectorContent;
        for ($i=0;$i<20;$i++){
            $productos = array_slice($this->productos,$i*1000, 1000);
            $contenido = array_slice($this->productoContent,$i*1000, 1000);
            $this->updateProducts($productos,$contenido,$i);
        }
    }

    /*
     * Recorremos los productos
     * para el precio, fotografias,
     * caracteristicas... etc
     */
     //$contadorProducto
     public function updateProducts($productos,$contenido,$contador){
        $nombreFichero         = 'products_import'.$contador.'csv';
        $output                = fopen($nombreFichero, 'w');
        $vectorProductos       = array();
        $vectorProductosLabel  = $this->getVectorLabelProductos();
        $contadorProducto      = 0;
        foreach($productos as $producto){
            $vectorCsv = $this->setUpdateProductos($this->scrapeProductos($contenido[$contadorProducto]),$producto["ID"],$producto["parent"],$producto["Short description"]);
            array_push($vectorProductos,$vectorCsv);
            $contadorProducto++;
        }
        foreach ($vectorProductos as $campo) {
            fputcsv($output, $campo,';');
        }
        fclose($output);
     }

    /*
     * Cortamos content de productos
     */
    public function scrapeProductos($contenido){
        $inicio        = '<div class="product-essential" itemtype="http://schema.org/Product" itemscope="">';
        $final         = '<div id="trustivity_comments">';
        $cadena        = "";
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
        return $cadena;
    }


    /*
    * Guardamos los productos
    * para el precio, fotografias,
    * caracteristicas... etc
    */
    public function setUpdateProductos($content,$id,$parent,$descCorta){
        $nombre          = $this->queryGetNameAndReference($this->scrapeProductos($content));
        $images          = $this->queryGetImages($this->scrapeProductos($content));
        $priceVector     = $this->queryGetPriceAndOldPrice($this->scrapeProductos($content));
        $vectorCarac     = $this->queryGetCaracteristicas($this->scrapeProductos($content));
        $marca           = $this->queryGetMarca($this->scrapeProductos($content));
        $price           = $priceVector["Price"];
        $Wholesale       = $priceVector["Wholesale price"];
        $caracteristicas = $vectorCarac["carac"];
        $descripcion     = $vectorCarac["desc"];
        $vectorCsv = $this->writeCsvFieldsProductos($id,$nombre,$parent,$id,$images,$Wholesale,$price,$caracteristicas,$descripcion,$marca,$descCorta);
        return $vectorCsv;
    }




    /*
     * Write Csv Fields
     */
    public function writeCsvFieldsProductos($id,$name,$parent,$reference,$image,$wholesaleprice,$price,$feature,$description,$manufacturer,$shortDescription){
        //echo "La descripcion 3 es: ".$shortDescription."<br>";
        $vector = array(
            $id,
            1,
            $name,
            $parent,
            $price,
            31,
            $wholesaleprice,
            "",
            "",
            "",
            "",
            "",
            $reference,
            "",
            "",
            $manufacturer,
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
            $shortDescription,
            $description,
            $name,
            $name,
            $name,
            $shortDescription,
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            $image,
            "",
            $feature,
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
        return $vector;
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
    * Descripción padre
    */
    public function queryDescripcion($content){
        $contador          = 0;
        $vectorDescripcion = array();
        $descripcion       = "";
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "category-description std";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            $div   = $elemento->item(0);
            $spans = $div->getElementsByTagName("span");
            if ($spans->length > 0){
                foreach($spans as $span){
                    $descripcion .= $span->nodeValue;
                }
            }else{
                $ps = $div->getElementsByTagName("p");
                if ($ps->length > 0) {
                    foreach ($ps as $p) {
                        $descripcion .= $p->nodeValue;
                    }
                }
            }
        }
        return $descripcion;
    }


    /*
    * Obtenemos imagenes de categoria index
     * imagenes de los padres
    */
    public function getImagenesIndexCategorias(){
        foreach($this->indexContent as $content){
            //echo "--------------------- Imagenes --------------<br>";
            $vectorImagenes = array();
            $dom            = new DOMDocument();
            $dom->loadHTML("$content");
            $xpath          = new DOMXPath($dom);
            $tag            = "div";
            $class          = "home-category-box";
            $consulta       = "//".$tag."[@class='".$class."']";
            $resultados     = $xpath->query($consulta);
            if ($resultados->length > 0){
                $contador = 0;
                foreach($resultados as $imagenes){
                    if ($contador == 0){
                        $todasImagenes = $imagenes->getElementsByTagName("img");
                        if ($todasImagenes->length > 0){
                            foreach($todasImagenes as $imagen){
                                $urlImagen = $imagen->getAttribute("src");
                                //echo "url imagen categorias padre: ".$urlImagen."<br>";
                                array_push($vectorImagenes,$urlImagen);
                            }
                        }
                    }
                    $contador++;
                }
            }
            //echo "--------------------- Fin Imagenes --------------<br>";
        }
        return $vectorImagenes;
    }

    /*
     * Guardamos imagenes de todos
     * los Hijos y de todos los nietos
     */
    public function listadoHijosNietosImagenes($content){
        $contador               = 0;
        $vectorImagenes         = array();
        $dom                    = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath           = new DOMXPath($dom);
        $tag            = "div";
        $class          = "widget em-widget-new-products-grid";
        $consulta       = "//".$tag."[@class='".$class."']";
        $widget         = $xpath->query($consulta);
        //var_dump($widget);
        if ($widget->length > 0){
            foreach($widget as $res){
                if ($contador == 0){
                    $resultados = $res->getElementsByTagName("img");
                    if ($resultados->length > 0){
                        foreach($resultados as $img){
                            $urlImagen = $img->getAttribute("src");
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
    * Guardamos marcas
    * imágenes del Index
    */
    // Index
    public function queryMarcasIndex(){
        foreach ($this->indexContent as $content){
            $vectorImagenes  = array();
            $vectorNombres   = array();
            $dom             = new DOMDocument();
            $dom->loadHTML("$content");
            $xpath           = new DOMXPath($dom);
            $tag             = "div";
            $class           = "featured-cat";
            $consulta        = "//".$tag."[@class='".$class."']";
            $elemento        = $xpath->query($consulta);
            if ($elemento->length > 0){
                foreach($elemento as $elemen){
                    $imgs = $elemen->getElementsByTagName("img");
                    $h2s  = $elemen->getElementsByTagName("h2");
                    if ($imgs->length > 0){
                        $img = $imgs->item(0)->getAttribute("src");
                        //echo "img: ".$img."<br>";
                        array_push($vectorImagenes,$img);
                    }
                    if ($h2s->length > 0){
                        $h2 = ltrim(rtrim($h2s->item(0)->nodeValue));
                        //echo "h2: ".$h2."<br>";
                        array_push($vectorNombres,$h2);
                    }
                }
            }
        }
        $vectorNombreMarcaImagen               = array_combine($vectorNombres,$vectorImagenes);
        $this->vectorImagenesPrincipalesMarcas = array_merge($this->vectorImagenesPrincipalesMarcas,$vectorNombreMarcaImagen);
    }

    /*
     * Obtenemos los nombres y las imagenes
     * de las marcas de los padres, hijos y nietos
     */
    public function queryMarcasPrincipales($opcion){
        $contador        = 0;
        $vectorImagenes  = array();
        $vectorNombres   = array();
        if ($opcion == 1){
             $nombre = "padreContent";
        }else if ($opcion == 2){
            $nombre = "hijoContent";
        }else if ($opcion == 3){
            $nombre = "nietoContent";
        }
        foreach ($this->{$nombre} as $content){
            $dom             = new DOMDocument();
            $dom->loadHTML("$content");
            $xpath           = new DOMXPath($dom);
            $tag             = "div";
            $class           = "home-category-box";
            $consulta        = "//".$tag."[@class='".$class."']";
            $elemento        = $xpath->query($consulta);
            if ($elemento->length > 0){
                $div     = $elemento->item(0);
                $imgs    = $div->getElementsByTagName("img");
                $strongs = $div->getElementsByTagName("strong");
                foreach($imgs as $img){
                    array_push($vectorImagenes,$img->getAttribute("src"));
                }
                foreach($strongs as $strong){
                    $marcaNombre = explode(" ",$strong->nodeValue);
                    $marca       = $marcaNombre[count($marcaNombre)-1];
                    $marca       = rtrim(ltrim($marca));
                    array_push($vectorNombres,$marca);
                }
            }
            $contador++;
        }
        $vectorNombreMarcaImagen               = array_combine($vectorNombres,$vectorImagenes);
        $this->vectorImagenesPrincipalesMarcas = array_merge($this->vectorImagenesPrincipalesMarcas,$vectorNombreMarcaImagen);
    }


    /*
     * Preguntamos por el
     * numero de productos de los
     * hijos sin nietos
     */

    public function queryTotalesProductos($content){
        $dom                = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath              = new DOMXPath($dom);
        $tag                = "p";
        $class              = "amount";
        $consulta           = "//".$tag."[@class='".$class."']";
        $resultados         = $xpath->query($consulta);
        if ($resultados->length > 0){
            $findme    = 'Artículo(s)';
            $pos1 = stripos($resultados->item(0)->nodeValue, $findme);
            $numeroProductos = ltrim(rtrim($resultados->item(0)->nodeValue));
            //echo "Número Productos: ".$numeroProductos."<br>";
            //echo "Pos1: ".$pos1."<br>";
            if ($pos1 !== false) {
                $numeroProductos = str_replace($findme," ",$numeroProductos);
                $numeroProductos = ltrim(rtrim($numeroProductos));
                //echo "Número productos: ".$numeroProductos."<br>";
            }else{
                //"ARTÍCULOS 1 A 51 DE 69 TOTALES";
                $numeroProductos = explode(" ",$numeroProductos);
                //var_dump($numeroProductos);
                $numeroProductos = $numeroProductos[3];
            }
            //echo "numero de productos: ".$numeroProductos."<br>";
            //echo "url: ".$this->vectorUrls[$contador]." Productos: ".$resultados->item(0)->nodeValue."<br>";
        }
        return $numeroProductos;
    }


    /*
    * Guardamos la url de los hijos
    * sin ietos
    */
    public function queryUrlProducto($content){
       $vectorUrls     = array();
       $dom            = new DOMDocument();
       $dom->loadHTML("$content");
       $xpath          = new DOMXPath($dom);
       $tag            = "a";
       $class          = "product-image";
       $consulta       = "//".$tag."[@class='".$class."']";
       $resultados     = $xpath->query($consulta);
       if ($resultados->length > 0) {
           foreach ($resultados as $resultado) {
               //echo "url productos: ".$resultado->getAttribute("href")."<br>";
               array_push($vectorUrls,$resultado->getAttribute("href"));
           }
       }
        return $vectorUrls;
    }

    /*
     * Cogemos todas las descripciones
     * cortas de los productos de los hijos
     * sin nietos
     */
    public function queryDescCorta($content){
       $vectorDesc     = array();
       $dom            = new DOMDocument();
       $dom->loadHTML("$content");
       $xpath          = new DOMXPath($dom);
       $cssname        = "desc-product";
       $tag            = "div";
       $consulta       = "//".$tag."[@class='".$cssname."']";
       $elementos      = $xpath->query($consulta);
       foreach($elementos as $elemento){
           //echo "Descripcion corta es: ".$elemento->nodeValue."<br><br>";
           $valor = rtrim(ltrim($elemento->nodeValue));
           //$rest  = substr($valor, 0, 799);
           $descCorta = rtrim(ltrim($valor));
           $descCorta = mb_strimwidth($descCorta, 0, 790, "...");
           array_push($vectorDesc,$descCorta);
       }
       return $vectorDesc;
    }


    /*
     * Consulta detalle
     * Nombre,referemcia,precio,antiguo precio, opciones, imágenes, características
     */
    public function queryGetNameAndReference($content){
       $dom                   = new DOMDocument();
       $dom->loadHTML("$content");
       $xpath                  = new DOMXPath($dom);
       $cssname                = "product-shop";
       $tag                    = "div";
       $consulta               = "//".$tag."[@class='".$cssname."']";
       $elements               = $xpath->query($consulta);
       if ($elements->length > 0){
           $contador           = 0;
           foreach($elements as $elemento){
               $cssname        = "product-name";
               $consulta       = "div[@class='".$cssname."']";
               $elementos      = $xpath->query($consulta,$elemento);
               $contador       = 0;
               if ($elementos->length > 0){
                   foreach($elementos as $el){
                       if ($contador == 0){
                           if ($el->hasAttribute("itemprop") && $el->getAttribute("itemprop") == "name") {
                               $nombre = rtrim(ltrim($el->nodeValue));
                               //echo "nombre: " . $nombre . "<br>";
                               $nombre = rtrim(ltrim($nombre));
                               $rest = mb_strimwidth($nombre, 0, 127, "...");
                               $nombre = $rest;
                               //array_push($this->vectorNombreHijoSinNietos, $nombre);
                           }
                       }else{
                           $referencia = rtrim(ltrim($el->nodeValue));
                           //echo "referencia: ".$referencia."<br>";
                           $referencia = rtrim(ltrim($referencia));
                           //array_push($this->vectorNReferenciaHijoSinNietos,$referencia);
                       }
                       $contador++;
                   }
               }
           }
       }
       return $nombre;
    }

    /*
     * Obtenemos las imagenes
     * de todos los productos
     * de los hijos sin nietos
     */
    public function queryGetImages($content){
        $vector         = array();
        $imagenes       = "";
        $dom            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath          = new DOMXPath($dom);
        $cssname        = "prozoom-small-image";
        $tag            = "a";
        $consulta       = "//".$tag."[@class='".$cssname."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                //echo "url imagen: ".$element->getAttribute("href")."<br>";
                array_push($vector,$element->getAttribute("href"));
                $imagenes .= $element->getAttribute("href")."," ;
            }
            $imagenes = substr($imagenes,0,strlen($imagenes)-1);
        }
        return $imagenes;
    }

    /*
     * Obtenemos los precios
     * y precios antiguis
     * de todos los productos
     */
    public function queryGetPriceAndOldPrice($content){
        $vector         = array();
        $dom            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "tiempo-entrega-div";
        $tag            = "div";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $objeto         = $xpath->query($consulta);
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
                                        //echo "Precio: ".$precio."<br>";
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

    //---------- FALTA COGER LA DESCRIPCION CORTA Y LA GRAN DESCRIPCION

    /*
     * Obtenemos las caracteristicas
     * de todos los productos
     */
    public function queryGetCaracteristicas($content){
        // th = description
        // td = value
        $dom            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "data-table";
        $tag            = "table";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
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
                    $value = ltrim(rtrim($td->nodeValue));
                    $value = str_replace(":"," ",$value);
                    $value = str_replace(";"," ",$value);
                    array_push($caracValue,$value);
                }
                foreach($ths as $th){
                    //var_dump($td);
                    $encontrado = FALSE;
                    $valor = ltrim(rtrim($th->nodeValue));
                    foreach($this->vectorCaracteristicasDefault as $default){
                        if ($default == $valor){
                            $encontrado = TRUE;
                        }
                    }
                    if ($encontrado == FALSE){
                        array_push($this->vectorCaracteristicasDefault,$valor);
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
                $valorTruncado = substr($valor, 0, 254);
                $caracString.= $caracTitle[$contador].":".$valorTruncado.",";
            }else if ($caracTitle[$contador] == "Descripción"){
                $descripcion = rtrim(ltrim($valor));
            }
            $contador++;
        }
        $caracString = substr($caracString,0,strlen($caracString)-1);
        $vector = array(
            "carac" => $caracString,
            "desc"  => $descripcion
        );
        //echo $caracString."<br>";
        return $vector;
    }

    /*
     * Obtenemos la marca
     * de los productos
     */
    public function queryGetMarca($content){
        $dom            = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "tiempo-entrega-p";
        $tag            = "p";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0){
            foreach($elements as $element){
                $consulta = "span";
                $spans = $xpath->query($consulta,$element);
                foreach($spans as $span){
                    //echo "span: ".$span->nodeValue;
                    $marcaValue = rtrim(ltrim($span->nodeValue));
                    $marca = $marcaValue;
                }
            }
        }
        return $marca;
    }

    /*
     * Obtenemos las opciones
     * de los productos
     */
    public function getOptions(){
        //$this->xpath    = new DOMXPath($this->document);
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
                        //echo "La caracteristica es: ".$span->nodeValue."<br>";
                    }
                }
            }
        }
        echo "<br><br>";
    }
}
?>