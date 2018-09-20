<?php
include_once "vendor/autoload.php";
use clases\ObjectFerreteria;
use clases\LoadUrls;
use clases\Multicurl;
use DOMDocument;
use DOMXPath;

$vectorUrl        = array(0 => 'http://www.ferreteria.net/sartenes/packs-especiales/packs-castey/pack-saludable-castey-yellow.html');

/*
 * Objeto inicial donde iremos guardando
 * todos nuestros vectores
 */
$ferreteriaObject = new ObjectFerreteria();
$vectorContent    = array();
foreach($vectorUrl as $url){
    // Crea un nuevo recurso cURL
    $ch = curl_init();
    // Establece la URL y otras opciones apropiadas
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Captura la URL y la envía al navegador
    //$content = curl_exec($ch);
    array_push($vectorContent,curl_exec($ch));
    // Cierrar el recurso cURLy libera recursos del sistema
    curl_close($ch);
}

$vector          = scrapePadresHijosNietos($vectorContent);
$nombre          = queryGetNameAndReference($vector[0]);
$images          = queryGetImages($vector[0]);
$priceVector     = queryGetPriceAndOldPrice($vector[0]);
$vectorCarac     = queryGetCaracteristicas($vector[0]);
$marca           = queryGetMarca($vector[0]);

echo "El nombre es: ".$nombre."<br>";
var_dump($images);
var_dump($priceVector);
var_dump($vectorCarac);
echo "la marca es: ".$marca."<br>";

function scrapePadresHijosNietos($contenidoVector){
    $inicio        = '<div class="product-essential" itemtype="http://schema.org/Product" itemscope="">';
    $final         = '<div id="trustivity_comments">';
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
    var_dump($cadena);
    return $vector;
}

function queryGetNameAndReference($content){
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


function queryGetImages($content){
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

function queryGetPriceAndOldPrice($content){
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

function queryGetCaracteristicas($content){
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
                /*
                foreach($this->vectorCaracteristicasDefault as $default){
                    if ($default == $valor){
                        $encontrado = TRUE;
                    }
                }
                if ($encontrado == FALSE){
                    array_push($this->vectorCaracteristicasDefault,$valor);
                }
                */
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

function queryGetMarca($content){
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


?>