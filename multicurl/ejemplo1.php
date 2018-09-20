<?php
/**
 * Ejemplo 1
 */
// example of how to use basic selector to retrieve HTML contents
include_once "MultiCurl.class.php";

// cUrl Vector Principal
$url                             = array(0 => 'https://ferreteria.es');
$contenido                       = array();
$contentPadres                   = array();
$categoriaPrincipal              = array();
// Urls padres,hijos,nietos
$vectorUrls                      = array();
$vectorUrlsPadres                = array();
$vectorUrlsHijos                 = array();
$vectorUrlsHijosNietos           = array();
$vectorUrlHijosSinNietos         = array();
$vectorUrlsNietos                = array();
// Padres
$vectorImagenesPadres            = array();
$vectorImagenesPrincipalesMarcas = array();
$vectorDescripcionPadre          = array();
// Hijos
$vectorHijosImagenes             = array();
// HijosConNietos
$vectorHijosNietosImagenes       = array();
$vectorDescripcionHijosNietos    = array();
$contador                        = 0;
// Hijo sin nietos (PRODUCTOS)
$vectorNumProdHijoSinNietos      = array();
$vectorDescHijoSinNietos         = array();
$vectorUrlProdHijoSinNietos      = array();
// Nietos(PRODUCTOS)
$vectorNumProdNietos             = array();
$vectorDescCortaNietos           = array();
$vectorUrlProdHijoNietos         = array();

/*
 * Cogemos todos los content
 * de todas las paginas
 */
/*
function curl_multi_download($urls, $callback, $custom_options = null,$opcion) {
    $rolling_window = 5;
    $rolling_window = (sizeof($urls) < $rolling_window) ? sizeof($urls) : $rolling_window;
    $master = curl_multi_init();
    $curl_arr = array();
    $std_options = array(
        CURLOPT_RETURNTRANSFER => true,
        //CURLOPT_FOLLOWLOCATION => true,
        //CURLOPT_MAXREDIRS => 5,
        CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
        CURLOPT_HEADER => FALSE,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_SSL_VERIFYPEER => false
    );
    $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;
    for ($i = 0; $i < $rolling_window; $i++) {
        $ch = curl_init();
        $options[CURLOPT_URL] = $urls[$i];
        echo "url 1: ".$urls[$i]."<br>";
        curl_setopt_array($ch,$options);
        curl_multi_add_handle($master, $ch);
    }
    do {
        while(($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
        if($execrun != CURLM_OK)
            break;
        while($done = curl_multi_info_read($master)) {
            $info = curl_getinfo($done['handle']);
            if ($info['http_code'] == 200)  {
                echo "url 2: ".$urls[$i]."<br>";
                $output = curl_multi_getcontent($done['handle']);
                $callback($output,$urls[$i],$opcion);
                if ( isset($urls[$i+1]) ) {
                    $ch = curl_init();
                    $options[CURLOPT_URL] = $urls[$i++];  // increment i
                    curl_setopt_array($ch, $options);
                    curl_multi_add_handle($master, $ch);
                }
                curl_multi_remove_handle($master, $done['handle']);

            } else {
                echo "Ha habido un error<br>";
            }
        }
    } while ($running);
    curl_multi_close($master);
    return true;
}
*/


/*
 * Llamada a funciones
 */
$contenido = contentUrls($url);
$vectorImagenesPadres = getImagenesIndexCategorias($contenido[0]);
leerUrls($contenido[0]);
contarHijosDePadresYNietosDeHijos();

/*
 * Leemos todas las urls
 */
function leerUrls($contenido){
    global $vectorUrlsPadres;
    global $vectorUrlsHijos;
    global $vectorUrlsHijosNietos;
    global $vectorUrlsNietos;
    global $vectorPrincipal;
    $dom             = new DOMDocument();
    @$dom->loadHTML($contenido);
    $xpath           = new DOMXPath($dom);
    $elemento        = $dom->getElementById("left-nav");
    echo "--------------------- Urls Categorias, Subcategorias, Sub SubCategiruas  --------------<br>";
    $encontradoHijos = FALSE;
    $dentroHijos     = FALSE;
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
                $nombreCat    = rtrim(ltrim($anchor->nodeValue));
                $mystring     = $anchor->parentNode->getAttribute("class");
                $findmeLevel0 = 'level0';
                $posLevel0 = strpos($mystring, $findmeLevel0);
                if ($posLevel0 !== false) {
                    $url         = $anchor->getAttribute("href");
                    //echo "url padre: ".$url."<br>";
                    array_push($vectorUrlsPadres,$url);
                    crearPadre($level0,$contadorCsv,$url,$nombreCat);
                    $encontradoHijos = FALSE;
                    $dentroHijos     = FALSE;
                    $level0++;
                    $contadorCsv++;
                    $contadorPadre  = $contadorCsv;
                    $level1 = 0;
                    $level2 = 0;
                } else {
                    $findmeLevel1 = 'level1';
                    $posLevel1 = strpos($mystring, $findmeLevel1);
                    if ($posLevel1 !== false) {
                        $url    = $anchor->getAttribute("href");
                        //echo "url hijo: ".$url."<br>";
                        array_push($vectorUrlsHijos,$url);
                        crearHijo($level0,$level1,$contadorPadre,$contadorCsv,$url,$nombreCat);
                        $contadorHijo++;
                        $parent = (int)($contadorPadre-1);
                        $encontradoHijos = FALSE;
                        $level1++;
                        $contadorCsv++;
                        $contadorNieto = $contadorCsv;
                    } else {
                        $findmeLevel2 = 'level2';
                        $posLevel2 = strpos($mystring, $findmeLevel2);
                        if ($posLevel2 !== false) {
                            $url       = $anchor->getAttribute("href");
                            array_push($vectorUrlsNietos,$url);
                            //echo "url nieto: ".$url."<br>";
                            if (!$encontradoHijos){
                                $value = $vectorUrlsHijos[$contadorHijo-1];
                                //echo "El value es: ".$value."<br>";
                                array_push($vectorUrlsHijosNietos,$value);
                                $encontradoHijos = TRUE;
                                //$dentroHijos     = TRUE;
                                updateHijosNoProductosHijoSiNietos($level0,$level1);
                            }
                            crearNieto($level0,$level1,$level2,$contadorNieto,$contadorCsv,$url,$nombreCat);
                            $contadorCsv++;
                            $level2++;
                        }
                    }
                }
            }
        }
    }
    echo "--------------------- Fin Categorias --------------<br>";
}

/*
 * Normalizamos el vector
 */
$vectorUrlHijosSinNietos = array_diff($vectorUrlsHijos,$vectorUrlsHijosNietos);
$vectorTemp              = array();
foreach($vectorUrlHijosSinNietos as $vUrlHijosSinNietos){
    array_push($vectorTemp,$vUrlHijosSinNietos);
}
$vectorUrlHijosSinNietos = $vectorTemp;


function crearPadre($level0,$contadorCsv,$url,$nombreCat){
    global $categoriaPrincipal;
    global $vectorImagenesPadres;
    $categoriaPrincipal[$level0]                = array();
    $categoriaPrincipal[$level0]["id"]          = $contadorCsv;
    $categoriaPrincipal[$level0]["name"]        = $nombreCat;
    $categoriaPrincipal[$level0]["url"]         = $url;
    $categoriaPrincipal[$level0]["parent"]      = 2;
    $categoriaPrincipal[$level0]["imagen"]      = $vectorImagenesPadres[$level0];
    $categoriaPrincipal[$level0]["numeroHijos"] = "";
    $categoriaPrincipal[$level0]["content"]     = "";
    $categoriaPrincipal[$level0]["descripcion"] = "";
    $categoriaPrincipal[$level0]["hijos"]       = array();
}

function updateNumeroHijosPadre($level0,$numeroHijos){
    global $categoriaPrincipal;
    $categoriaPrincipal[$level0]["numeroHijos"] = $numeroHijos;
}

function crearHijo($level0,$level1,$contadorPadre,$contadorCsv,$url,$nombreCat){
    global $categoriaPrincipal;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["id"]              = $contadorCsv;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["url"]             = $url;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["name"]            = $nombreCat;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["parent"]          = ($contadorPadre-1);
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["imagen"]          = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["content"]         = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["descripcion"]     = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["numeroProductos"] = 0;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1]["productos"]       = array();
}

function updateHijosNoProductosHijoSiNietos($level0,$level1){
   global $categoriaPrincipal;
   unset($categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["productos"]);
   unset($categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["numeroProductos"]);
   $categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["numeroNietos"]    = 0;
   $categoriaPrincipal[$level0 - 1]["hijos"][$level1-1]["nietos"]          = array();
}

function crearNieto($level0,$level1,$level2,$contadorNieto,$contadorCsv,$url,$nombreCat){
    global $categoriaPrincipal;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["id"]              = $contadorCsv;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["url"]             = $url;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["name"]            = $nombreCat;
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["parent"]          = (int)($contadorNieto-1);
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["imagen"]          = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["content"]         = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["numeroProductos"] = "";
    $categoriaPrincipal[$level0 - 1]["hijos"][$level1 - 1]["nietos"][$level2]["productos"] = array();
}

function contarHijosDePadresYNietosDeHijos(){
    global $categoriaPrincipal;
    $contadorPadre = 0;
    $contadorHijo  = 0;
    foreach($categoriaPrincipal as $padres){
        $categoriaPrincipal[$contadorPadre]["numeroHijos"] = count($categoriaPrincipal[$contadorPadre]["hijos"]);
        foreach($padres["hijos"] as $hijos){
            if (isset($hijos["nietos"])){
                $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroNietos"] = count($categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["nietos"]);
            }
            $contadorHijo++;
        }
        $contadorHijo = 0;
        $contadorPadre++;
    }
}

/*
 * Obtenemos imagenes de categoria index
 */
function getImagenesIndexCategorias($content){
    //echo "--------------------- Imagenes --------------<br>";
    $vectorImagenes = array();
    $dom      = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath    = new DOMXPath($dom);
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
    $contador = 0;
    var_dump($vectorImagenes);
    return $vectorImagenes;
}


/*
 * Volcamos todos los
 * datos de padres,hijos,nietos
 */

$vectorUrlsHijos = array_diff($vectorUrlsHijos,$vectorUrlsHijosNietos);

/*
echo "------------- Padres --------<br>";
var_dump($vectorUrlsPadres);
echo "----------------------------------------<br>";
echo "------------- Hijos todos --------<br>";
var_dump($vectorUrlsHijos);
echo "----------------------------------------<br>";
echo "------------- Hijos Sin nietos --------<br>";
var_dump($vectorUrlHijosSinNietos);
echo "----------------------------------------<br>";
echo "------------- Hijos Con nietos --------<br>";
var_dump($vectorUrlsHijosNietos);
echo "----------------------------------------<br>";
echo "------------- Nietos --------<br>";
var_dump($vectorUrlsNietos);
echo "----------------------------------------<br>";
*/


/*
 * Lanzamos padre content
 */


//$contentPadres = contentUrls($vectorUrlsPadres);


$contenido    = array();
$respuestaUrl = array();
curl_multi_download($vectorUrlsPadres,"guardarInformacion",array(),"contentPadres");
//$contentPadres = $contenido;
$contador      = 0;



/*
 * Recorremos padre content
 * y llamamos a funcion para
 * recoger todas las imagenes
 * de padre content
 */
//global $vectorImagenesPadres;
//global $vectorUrlsPadres;


foreach($contentPadres as $content){
    // Listado categorias imagenes
    array_push($vectorHijosImagenes,querytListadoCategoriasImagenes($content));
    echo "url 4: ".$vectorUrlsPadres[$contador]."<br>";
    // Marcas principales
    //$vector = queryMarcasPrincipales($content);
    //var_dump($vector);
    //$vectorImagenesPrincipalesMarcas = array_merge($vectorImagenesPrincipalesMarcas,$vector);
    //$vectorImagenesPrincipalesMarcas = array_unique($vectorImagenesPrincipalesMarcas);
    // Descripciones
    //array_push($vectorDescripcionPadre,queryDescripcionPadre($content));
    $contador++;
}

guardarImagenesHijosVector($vectorHijosImagenes);
$contador = 0;
//guardamosDescripcionPadre($vectorDescripcionPadre);


echo "---------- Sacamos todas las imagenes de los hijos<br>";
var_dump($vectorHijosImagenes);
echo "--------------------------------------<br>";
/*
echo "---------- Sacamos todas las imagenes de los marcas<br>";
var_dump($vectorImagenesPrincipalesMarcas);
echo "--------------------------------------<br>";
echo "---------- Sacamos la descripción padre-------<br>";
var_dump($vectorDescripcionPadre);
echo "----------------------------------------------<br>";

var_dump($categoriaPrincipal);
*/

/*
* Obtemeos las imagenes
* de las categorias
*/
function querytListadoCategoriasImagenes($content){
    $vectorImagenes = array();
    $dom             = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath           = new DOMXPath($dom);
    $tag            = "div";
    $class          = "widget em-widget-new-products-grid";
    $consulta       = "//".$tag."[@class='".$class."']";
    $widget         = $xpath->query($consulta);
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
    $contador = 0;
    return $vectorImagenes;
}

/*
 * Guardamos imagenes
 * Hijos en vector
 */
function guardarImagenesHijosVector($vectorHijosImagenes){
    global $categoriaPrincipal;
    $contadorPadre = 0;
    $contadorHijo  = 0;
    foreach($categoriaPrincipal as $padre){
        //echo "Entra aqui";
        if (isset($padre["hijos"])){
            foreach($padre["hijos"] as $hijos){
                //echo "Entra en hijos";
                //echo "valor imagen: ".$vectorHijosImagenes[$contadorPadre][$contadorHijo]."<br>";
                if (isset($categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["imagen"]) && isset ($vectorHijosImagenes[$contadorPadre][$contadorHijo])){
                    $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["imagen"] = $vectorHijosImagenes[$contadorPadre][$contadorHijo];
                    $contadorHijo++;
                }
            }
        }
        $contadorHijo = 0;
        $contadorPadre++;
    }
}

/*
 * Obtenemos Imágenes
 * Marcas
 */
function queryMarcasPrincipales($content){
    $vectorImagenes  = array();
    $vectorNombres   = array();
    global $contador;
    global $vectorUrlsPadres;
    $dom             = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath           = new DOMXPath($dom);
    $tag             = "div";
    $class           = "home-category-box";
    $consulta        = "//".$tag."[@class='".$class."']";
    $elemento        = $xpath->query($consulta);
    //echo "vector urls padres: ".$vectorUrlsPadres[$contador]."<br>";
    if ($elemento->length > 0){
        $div     = $elemento->item(0);
        $imgs    = $div->getElementsByTagName("img");
        $strongs = $div->getElementsByTagName("strong");
        var_dump($imgs);
        var_dump($strongs);
        foreach($imgs as $img){
            //echo "imagen: ".$img->getAttribute("src")."<br>";
            array_push($vectorImagenes,$img->getAttribute("src"));
        }
        foreach($strongs as $strong){
            $marcaNombre = explode(" ",$strong->nodeValue);
            $marca       = $marcaNombre[count($marcaNombre)-1];
            $marca       = rtrim(ltrim($marca));
            //echo "marca: ".$marca."<br>";
            array_push($vectorNombres,$marca);
        }
    }
    var_dump($vectorNombres);
    var_dump($vectorImagenes);
    $vectorNombreMarcaImagen = array_combine($vectorNombres,$vectorImagenes);
    //var_dump($vectorNombreMarcaImagen);
    $contador++;
    return $vectorNombreMarcaImagen;
}

/*
 * Descripción padre
 */
function queryDescripcionPadre($content){
    $descripcion     = "";
    global $vectorDescripcionPadre;
    $dom             = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath           = new DOMXPath($dom);
    $tag             = "div";
    $class           = "category-description std";
    $consulta        = "//".$tag."[@class='".$class."']";
    $elemento        = $xpath->query($consulta);
    if ($elemento->length > 0){
        $div   = $elemento->item(0);
        $spans = $div->getElementsByTagName("span");
        if ($spans->length > 0){
           foreach($spans as $span){
             $descripcion .= $span->nodeValue;
           }
        }
    }
    return $descripcion;
}

function guardamosDescripcionPadre($vectorDescripcionPadre){
    global $categoriaPrincipal;
    $contador = 0;
    foreach($categoriaPrincipal as $padre){
        if (isset($categoriaPrincipal[$contador]["descripcion"]) && isset($vectorDescripcionPadre[$contador])){
            $categoriaPrincipal[$contador]["descripcion"] = $vectorDescripcionPadre[$contador];
            $contador++;
        }
    }
}

/*
 * Lanzamos Hijo con nietos
 * para coger las imagenes
 * y las descripciones
 */

/*
$contentHijosConNietos = contentUrls($vectorUrlsHijosNietos);
//var_dump($vectorUrlsHijosNietos);
$contador = 0;


foreach($contentHijosConNietos as $content){
    //echo $vectorUrlsHijosNietos[$contador];
    $vectorHijosNietosImagenes[$contador] = queryImagenesHijosConNietos($content);
    array_push($vectorDescripcionHijosNietos,queryDescripcionHijosConNietos($content));
    $contador++;
}


$contador = 0;
gaurdarImagenesHijosConNietos();
guardarDescripcionHijosConNietos();
*/

/*
echo "------------- Imagenes Hijos Con Nietos --------------<br>";
var_dump($vectorHijosNietosImagenes);
echo "------------- Fin Imagenes Hijos Con Nietos --------------<br>";
echo "------------- Descripción Hijos Con Nietos --------------<br>";
var_dump($vectorDescripcionHijosNietos);
echo "------------- Fin Descripción Hijos Con Nietos --------------<br>";
*/

/*
 * Devuelve todas las imagenes
 * de las subcategorias
 */
function queryImagenesHijosConNietos($content){
    $vector   = array();
    $dom      = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath    = new DOMXPath($dom);
    $tag      = "ul";
    $class    = "products-grid";
    $consulta = "//".$tag."[@class='".$class."']";
    $element  = $xpath->query($consulta);
    //var_dump($element);
    if ($element->length > 0){
        $ul = $element->item(0);
        $imgs = $ul->getElementsByTagName("img");
        foreach($imgs as $img){
            array_push($vector,$img->getAttribute("src"));
        }
    }
    return $vector;
}

function gaurdarImagenesHijosConNietos(){
    global $vectorHijosNietosImagenes;
    global $categoriaPrincipal;
    $contadorNietosPrincipal  = 0;
    $contadorHijos            = 0;
    $contadorPadre            = 0;
    $contadorVectorNietos     = 0;
    $contadorHijosTipoVector  = 0;
    foreach($categoriaPrincipal as $padre){
        foreach($padre["hijos"] as $hijos){
            if (isset($hijos["nietos"])){
                foreach($hijos["nietos"] as $nietos){
                    for ($i=0;$i<count($vectorHijosNietosImagenes);$i++){
                        if ($i == $contadorHijosTipoVector){
                            foreach($vectorHijosNietosImagenes[$i] as $imagen){
                              if ($contadorVectorNietos == $contadorNietosPrincipal){
                                  //echo "imagen: ".$imagen."<br>";
                                  $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijos]["nietos"][$contadorNietosPrincipal]["imagen"] = $imagen;
                              }
                              $contadorVectorNietos++;
                            }
                        }
                    }
                    $contadorVectorNietos = 0;
                    $contadorNietosPrincipal++;
                }
                $contadorHijosTipoVector++;
            }
            $contadorNietosPrincipal = 0;
            $contadorHijos++;
        }
        $contadorHijos = 0;
        $contadorPadre++;
    }
}

/*
 * Devuelve las descripciones
 * de hijos con nietos
 */
function queryDescripcionHijosConNietos($content){
    $descripcion = "";
    $dom         = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath       = new DOMXPath($dom);
    $tag         = "div";
    $class       = "category-description std";
    $consulta    = "//".$tag."[@class='".$class."']";
    $elemento    = $xpath->query($consulta);
    if ($elemento->length > 0){
        $div     = $elemento->item(0);
        $spans   = $div->getElementsByTagName("span");
        if ($spans->length > 0){
            foreach($spans as $span){
               $descripcion.=$span->nodeValue;
            }
        }
    }
    return $descripcion;
}

function guardarDescripcionHijosConNietos(){
    global $vectorDescripcionHijosNietos;
    global $categoriaPrincipal;
    $contadorHijos           = 0;
    $contadorPadre           = 0;
    $encontradoHijo          = FALSE;
    $contadorEncontrado      = 0;
    foreach($categoriaPrincipal as $padre){
        foreach($padre["hijos"] as $hijos){
            if (isset($hijos["nietos"])){
                foreach($hijos["nietos"] as $nietos){
                    if (!$encontradoHijo){
                        if (isset($categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijos]["descripcion"]) && isset($vectorDescripcionHijosNietos[$contadorEncontrado])){
                            $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijos]["descripcion"] = $vectorDescripcionHijosNietos[$contadorEncontrado];
                            $encontradoHijo = TRUE;
                            $contadorEncontrado++;
                        }
                    }
                }
            }
            $encontradoHijo = FALSE;
            $contadorHijos++;
        }
        $contadorHijos = 0;
        $contadorPadre++;
    }
}

/*
 * Lanzamos Hijo sin nietos
 * para coger las números de productos
 * descripciones,url de los productos,el numero total de productos
 */


//$contentHijosSinNietos = contentUrls($vectorUrlHijosSinNietos);
/*
curl_multi_download($url,"guardarInformacion",array());
$contentHijosSinNietos = $contenido;
$contador = 0;

echo "------------ Todos los hijos ----------<br>";
var_dump($vectorUrlsHijos);
echo "------------ Fin Todos los hijos ----------<br>";
echo "------------ Todos los hijos con nietos ----------<br>";
var_dump($vectorUrlsHijosNietos);
echo "------------ Fin Todos los hijos con nietos ----------<br>";
echo "------------ Todos los hijos sin nietos ----------<br>";
var_dump($vectorUrlHijosSinNietos);
echo "------------ Fin Todos los hijos sin nietos ----------<br>";
*/

/*
foreach($contentHijosSinNietos as $content){
    //echo "------------- Descripción por Hijo Sin Nietos --------------<br>";
    array_push ($vectorDescHijoSinNietos,queryDescripcionHijosSinNietos($content));
    //echo "------------- Fin Descripción por Hijo Sin Nietos --------------<br>";
    //echo "------------- Número de productos por Hijo Sin Nietos --------------<br>";
    echo "url: ".$vectorUrlHijosSinNietos[$contador]."<br>";
    queryTotalesProductosPorCategoria($content);
    //array_push($vectorNumProdHijoSinNietos,queryTotalesProductosPorCategoria($content));
    //echo "------------- Fin Número de productos por Hijo Sin Nietos --------------<br>";
    //echo "------------- Url producto por Hijo Sin Nietos --------------<br>";
    //$vectorDescripcionHijosNietos = queryDescripcionHijosConNietos($content);
    //array_merge($vectorUrlProdHijoSinNietos,queryUrlProducto($content));
    //array_push($vectorUrlProdHijoSinNietos,queryUrlProducto($content));
    //echo "------------- Fin Url producto por Hijo Sin Nietos --------------<br>";
    //echo "------------- Desc corta del producto por Hijo Sin Nietos --------------<br>";
    //array_merge($vectorDescCortaHijoSinNietos,queryDescCorta($content));
    //echo "------------- Desc corta del producto por Hijo Sin Nietos --------------<br>";
    $contador++;
}
guardarDescripcionHijosSinNietos();
*/

//guardarTotalesProductosPorCategoria();
//var_dump($categoriaPrincipal);


/*
 * Obtenemos las descripciones
 * de los hijos sin nietos
 */
function queryDescripcionHijosSinNietos($content){
    $descripcion    = "";
    $dom            = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath          = new DOMXPath($dom);
    $tag            = "div";
    $class          = "category-description std";
    $consulta       = "//".$tag."[@class='".$class."']";
    $resultados     = $xpath->query($consulta);
    if ($resultados->length > 0){
        $div = $resultados->item(0);
        foreach($div->childNodes as $description){
            if (property_exists($description,"nodeValue") && $description->nodeName == "p"){
                $descripcion.= $description->nodeValue;
            }
        }
    }
    return $descripcion;
}

function guardarDescripcionHijosSinNietos(){
    global $categoriaPrincipal;
    global $vectorDescHijoSinNietos;
    $contadorPadre      = 0;
    $contadorHijo       = 0;
    $contadorVectorHijo = 0;
    foreach ($categoriaPrincipal as $padre){
        if (isset($padre["hijos"])){
            foreach($padre["hijos"] as $hijo){
                if (!isset($hijo["nietos"])){
                    $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["descripcion"] = $vectorDescHijoSinNietos[$contadorVectorHijo];
                    $contadorVectorHijo++;
                }
                $contadorHijo++;
            }
        }
        $contadorHijo = 0;
        $contadorPadre++;
    }
}


/*
 * Obtenemos los totales de los productos
 * de los hijo sin nietos
 */
function queryTotalesProductosPorCategoria($content){
    global $vectorUrlsHijos;
    global $contador;
    $dom            = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath          = new DOMXPath($dom);
    $tag            = "li";
    $class          = "item";
    $consulta       = "//".$tag."[@class='".$class."']";
    //$resultados     = $xpath->query($consulta);
    $resultados     = $dom->getElementsByTagName("li");
    var_dump($resultados);
}

function guardarTotalesProductosPorCategoria(){
    global $vectorNumProdHijoSinNietos;
    global $categoriaPrincipal;
    $contadorPadre      = 0;
    $contadorHijo       = 0;
    $contadorVectorHijo = 0;
    foreach ($categoriaPrincipal as $padre){
        if (isset($padre["hijos"])){
            foreach($padre["hijos"] as $hijo){
                if (!isset($hijo["nietos"])){
                    $categoriaPrincipal[$contadorPadre]["hijos"][$contadorHijo]["numeroProductos"] = $vectorNumProdHijoSinNietos[$contadorVectorHijo];
                    $contadorVectorHijo++;
                }
                $contadorHijo++;
            }
        }
        $contadorHijo = 0;
        $contadorPadre++;
    }
}


/*
* Cogemos la url del listado
* de los productos
*/

function queryUrlProducto($content){
    global $contador;
    global $vectorUrlsHijos;
    $vectorAnchors  = array();
    $dom            = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath          = new DOMXPath($dom);
    $tag            = "a";
    $class          = "product-image";
    $consulta       = "//".$tag."[@class='".$class."']";
    $resultados     = $xpath->query($consulta);
    if ($resultados->length > 0) {
        foreach ($resultados as $resultado) {
            array_push($vectorAnchors,$resultado->getAttribute("href"));
            //echo "url productos: ".$resultado->getAttribute("href")."<br>";
        }
    }
    $contador++;
    echo "url: ".$vectorUrlsHijos[$contador]."<br>";
    return $vectorAnchors;
}

function crearProducto(){
    $producto = array(
    );
}

/*
 * Cogemos la desc corta de el
 * listado de productos
 */

/*
function queryDescCorta($content){
    global $vectorUrlsHijos,$contador;
    $vectorDesc     = array();
    $dom            = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath          = new DOMXPath($dom);
    $cssname        = "desc-product";
    $tag            = "div";
    $consulta       = "//".$tag."[@class='".$cssname."']";
    $elementos      = $xpath->query($consulta);
    foreach($elementos as $elemento){
        //echo "Descripcion corta es: ".$elemento->nodeValue."<br><br>";
        $descCorta = rtrim(ltrim($elemento->nodeValue));
        array_push($vectorDesc,$descCorta);
    }
    echo "url: ".$vectorUrlsHijos[$contador]."<br>";
    return $vectorDesc;
}
*/
?>