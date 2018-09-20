<?php
include_once "vendor/autoload.php";
use clases\ObjectFerreteria;
use clases\LoadUrls;
use clases\Multicurl;

/*
 * Vector Inicial
 */
//$vectorUrl        = array(0 => 'https://ferreteria.es');
//$vectorUrl          = array(0 => 'http://www.espaiclinic.es');
$vectorUrl        = array(0 => 'http://www.ferreteria.net/index.html');

/*
 * Objeto inicial donde iremos guardando
 * todos nuestros vectores
 */
$ferreteriaObject = new ObjectFerreteria();

$vectorContent = multiRequest($vectorUrl);
echo "devolucion<br>";
$ferreteriaObject->setIndexContent($vectorContent);

/*
 * Ahora cogemos todos los
 * datos del vector Padre
 */
$vectorUrlsPadres = $ferreteriaObject->getPadres();
$vectorContent = multiRequest($vectorUrlsPadres);
echo "devolucion<br>";
$ferreteriaObject->setPadreContent($vectorContent);

/*
 * Ahora cogemos todos los hijos
 */

/*
$vectorUrlsHijos = $ferreteriaObject->getHijos();
$vectorContent = multiRequest($vectorUrlsHijos);
echo "devolucion<br>";
$ferreteriaObject->setHijoContent($vectorContent);
*/

/*
 * Ahora cogemos todos los nietos
 */
/*
$vectorUrlsNietos = $ferreteriaObject->getNietos();
$vectorContent = multiRequest($vectorUrlsNietos);
echo "devolucion<br>";
$ferreteriaObject->setNietoContent($vectorContent);

$vectorProductosUrl = $ferreteriaObject->getProductosUrl();
var_dump($vectorProductosUrl);
*/

/*
 * Ahora cogemos todos los productos
 */
/*
$vectorUrlProductos = $ferreteriaObject->getProducts();
$vectorContent      = multiRequest($vectorUrlProductos);
echo "devolucion<br>";
$ferreteriaObject->setProductoContent($vectorContent);
*/



function multiRequest($data) {
    $curly    = array();
    $result   = array();
    $mh       = curl_multi_init();
    $contador = 0;
    foreach ($data as $url) {
        $curly[$contador] = curl_init();
        curl_setopt($curly[$contador], CURLOPT_URL,            $url);
        curl_setopt($curly[$contador], CURLOPT_HEADER,         0);
        curl_setopt($curly[$contador], CURLOPT_RETURNTRANSFER, 1);
        curl_multi_add_handle($mh, $curly[$contador]);
        $contador++;
    }
    $contador = 0;
    $running  = null;
    do {
        curl_multi_exec($mh, $running);
    } while($running > 0);
    foreach($curly as $content){
        $result[$contador] = curl_multi_getcontent($content);
        curl_multi_remove_handle($mh, $content);
        $contador++;
    }
    echo "Hola<br>";
    curl_multi_close($mh);
    return $result;
}


//$categoriaPrincipal = $ferreteriaObject->getCategoriaPrincipal();
//var_dump($categoriaPrincipal);


/*
$directorio = 'G:\urlproyectos\ferreteria.es';
foreach ($vectorUrlsNietos as $url){
    $urlModificada = str_replace("http://www.ferreteria.net/"," ",$url);
    $urlModificada = rtrim(ltrim($urlModificada));
    $partes        = explode("/",$urlModificada);
    if (is_dir($directorio.'\\'.$partes[0])){
        echo "encontrado directorio: ".$partes[0]."<br>";
    }else{
        echo "no encontrado directorio: ".$partes[0]."<br>";
    }
    if (is_dir($directorio.'\\'.$partes[0].'\\'.$partes[1])){
        echo "encontrado directorio: ".$partes[1]."<br>";
    }else{
        echo "no encontrado directorio: ".$partes[1]."<br>";
    }
    if (is_file($directorio.'\\'.$partes[0].'\\'.$partes[1].'\\'.$partes[2])){
        echo "encontrado fichero: ".$partes[2]."<br>";
    }else{
        echo "no encontrado fichero: ".$partes[2]."<br>";
    }
    var_dump($partes);
}
*/

/*
$ficheros1  = scandir($directorio);
$ficheros2  = scandir($directorio, 1);
var_dump($ficheros1);
var_dump($ficheros2);
*/



/*
$vector = array(
    'http://www.ferreteria.net/sartenes.html',
    'http://www.ferreteria.net/ollas-y-cacerolas.htm',
    'http://www.ferreteria.net/cubos-de-basura-y-reciclaje.html',
    'http://www.ferreteria.net/cuchillos-y-tijeras-de-cocina.html',
    'http://www.ferreteria.net/carros-verduleros.html',
    'http://www.ferreteria.net/menaje-de-cocina.html',
    'http://www.ferreteria.net/muebles-de-jardin.html',
    'http://www.ferreteria.net/armarios-de-resina.html',
    'http://www.ferreteria.net/barbacoas.html',
    'http://www.ferreteria.net/piscinas.html',
    'http://www.ferreteria.net/camping-y-playa.html',
    'http://www.ferreteria.net/jardin.html',
    'http://www.ferreteria.net/calefaccion-y-estufas.html',
    'http://www.ferreteria.net/carros-de-compra-y-bolsas.html',
    'http://www.ferreteria.net/productos-de-bano.html',
    'http://www.ferreteria.net/muebles.html',
    'http://www.ferreteria.net/tendederos.html',
    'http://www.ferreteria.net/hogar.html',
    'http://www.ferreteria.net/herramienta-manual.html',
    'http://www.ferreteria.net/herramientas-electricas.html',
    'http://www.ferreteria.net/maquinaria.html',
    'http://www.ferreteria.net/escaleras-de-aluminio.html',
    'http://www.ferreteria.net/seguridad-infantil.html',
    'http://www.ferreteria.net/pinturas-y-esmaltes.html',
    'http://www.ferreteria.net/vestuario-y-calzado-laboral.html',
    'http://www.ferreteria.net/cerraduras.html',
    'http://www.ferreteria.net/buzones.html',
    'http://www.ferreteria.net/ferreteria-industrial.html',
    'http://www.ferreteria.net/iluminacion.html',
    'http://www.ferreteria.net/ferreteria-y-bricolaje.html'
);

$vectorTransformadas = array();

foreach($vector as $url){
    $urlTransformada = str_replace(".html"," ",$url);
    $urlTransformada = rtrim(ltrim($urlTransformada));
    array_push($vectorTransformadas,$urlTransformada);
}

$directories = glob($directorio . '/*' , GLOB_ONLYDIR);
$vectorUrls = array();
foreach($directories as $dir){
    $urlMod = str_replace('G:\urlproyectos\ferreteria.es/'," ",$dir);
    $urlMod = rtrim(ltrim($urlMod));
    $url = "http://www.ferreteria.net/".$urlMod;
    echo $url."<br>";
    $encontrado = FALSE;
    foreach($vectorTransformadas as $urlBuena){
        if ($urlBuena == $url){
            $encontrado = TRUE;
        }
    }
    if ($encontrado){
        array_push($vectorUrls,$url);
    }
}
var_dump($vectorUrls);
*/


/*
foreach($vectorUrls as $url){
    //$html   = str_get_html(file_get_contents($url)); //get the html returned from the following url
    $html   = curlGet($url);
    $images = listadoHijosNietosImagenes($html);
    //var_dump($html);
}
*/

/*
function curlGet($url)
{
    $ch = curl_init(); // Initialising cURL session
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch); // Executing cURL session
    curl_close($ch); // Closing cURL session
    return $results; // Return the results
}

function listadoHijosNietosImagenes($content){
    $contador               = 0;
    $vectorImagenes         = array();
    $dom                    = new DOMDocument();
    $dom->loadHTML("$content");
    $xpath           = new DOMXPath($dom);
    $tag            = "div";
    $class          = "widget em-widget-new-products-grid";
    $consulta       = "//".$tag."[@class='".$class."']";
    $widget         = $xpath->query($consulta);
    var_dump($widget);
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
*/
?>
