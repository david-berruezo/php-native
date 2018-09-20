<?php
namespace Proyecto\Superglobals;
/*
 * url: http://localhost/prueba/php/superglobals/get.php?nombre=Davidh
 * Obtenemos valores por el método
 * Get de diferentes maneras
 */
echo "Variable por _GET: " .$_GET["nombre"]. "<br>";
echo 'Hello ' . htmlspecialchars($_GET["nombre"]) . '!' . "<br>";
echo "Variable por HTTP_GET_VARS: " .$HTTP_GET_VARS["nombre"]. "<br>";

/*
 * Comparamos por el tipo de valort
 */
print_r($_GET);
echo("<br>");
if($_GET["nombre"] === "") echo "nombre is an empty string\n";
if($_GET["nombre"] === false) echo "nombre is false\n";
if($_GET["nombre"] === null) echo "nombre is null\n";
if(isset($_GET["nombre"])) echo "nombre is set\n";
if(!empty($_GET["nombre"])) echo "nombre is not empty";

/*
 * EXPLICACIÓN DE LO DE ARRIBA
 * He probado esto con un script.php, y volvió?:
 * a es una cadena vacía
 * se establece una
 * Por lo tanto, tenga en cuenta que un parámetro sin valor asociado, incluso sin un signo igual,
 * se considera que es una cadena vacía (""), isset () devuelve verdadero para él, y se considera vacía,
 * pero no falsa o nula. Parece obvio después de la primera prueba, pero sólo tenía que asegurarse.
 * Por supuesto, si no lo incluyo en mi consulta navegador, los rendimientos de script
 * Formación
 (
 )
 a es nulo
 */

/*
 * Ejemplo de los querystrings de anchors
 * no cogen los anchors ...
 * url http://localhost/prueba/php/superglobals/get.php?nombre=David#alumno
 *
 */
echo $_GET['nombre'];
// Devolverá solo el nombre

/*
 * Borramos querystring de url las que
 * nosotros queremos en este caso getVar1,getVar3
 * http://localhost/prueba/php/superglobals/get.php?getVar1=Something&getVar2=10&getVar3=ok&nombre=pepe
 */

echo("<br>");
echo("<br>");

$nuevaUrl = getUrlWithout(array("getVar1","getVar3"));
//result will be "http://www.example.net/index.php?getVar2=10"

function getUrlWithout($getNames){
    echo("Get names es: <br>");
    var_dump($getNames);
    echo("<br>");
    $url             = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    echo("La url es: ".$url ."<br>");
    $questionMarkExp = explode("?", $url);
    echo("La questionMarkExp es: <br>");
    var_dump($questionMarkExp);
    echo("<br>");
    $urlArray        = explode("&", $questionMarkExp[1]);
    echo("urlArray es: <br>");
    var_dump($urlArray);
    echo("<br>");
    $retUrl          = $questionMarkExp[0];
    $retGet          = "";
    $found           = array();
    foreach($getNames as $id => $name){
        echo("name: ".$name."<br>");
        foreach ($urlArray as $key=>$value){
            if(isset($_GET[$name]) && $value == $name."=".$_GET[$name])
                unset($urlArray[$key]);
        }
    }
    echo("urlArray borrado es: <br>");
    var_dump($urlArray);
    echo("<br>");
    $urlArray = array_values($urlArray);
    echo("urlArray con array_values es: <br>");
    var_dump($urlArray);
    echo("<br>");
    foreach ($urlArray as $key => $value){
        if($key<sizeof($urlArray) && $retGet!=="")
            $retGet.="&";
        $retGet.=$value;
    }
    return $retUrl."?".$retGet;
}
echo("La nueva url es: <br>");
var_dump($nuevaUrl);

$ch = curl_init("http://www.example.com/");
$fp = fopen("example_homepage.txt", "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
?>