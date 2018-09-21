<?php
/*
 * Guardamos la cookie
 * y recuperar la cookie
 */

/*
$value = 'cualquier cosa';
setcookie("TestCookie", $value);
setcookie("TestCookie", $value, time()+3600);
setcookie("TestCookie", $value, time()+3600, "/~rasmus/", "example.com", 1);
// Imprimir una cookie individual
echo $_COOKIE["TestCookie"];
echo $HTTP_COOKIE_VARS["TestCookie"];
// Otra manera de depurar/probar es viendo todas las cookies
print_r($_COOKIE);
*/

/*
 * Establecer la fecha de expiración a una hora atrás
 * Eliminar cookie
 */
// setcookie ("TestCookie", "", time() - 3600);
// setcookie ("TestCookie", "", time() - 3600, "/~rasmus/", "example.com", 1);

/*
$info = "Aplicación prueba php Cookie";
setcookie ("TestCookie", $info, time()+(3600*24*365), "/","www.cookie.net",FALSE);

$info = "Aplicación 2";
setcookie ("Cookie2", $info, time()+(3600*24*365), "/","www.cookie.net",FALSE);
"/","www.cookie.net"
$info = "Aplicación 3";
setcookie ("Cookie3", $info, time()+(3600*24*365), "/","www.cookie.net",FALSE);
*/


/*
 * Crear una cookie desde un array
 * Creamos una cookie desde un array
 * y la convertimos en formato Json
 */
$configuracion = array(
    "nombre"  => "Registro",
    "tiempo"  => (3600*24*365),
    "carpeta" => "/",
    "dominio" => "www.cookie.net",
    "opcion"  => FALSE
);

$datos = array(
   "nombre"  => "David",
   "edad"    => "37",
    "ciudad" => "Barcelona"
);

$cadena = json_encode($datos);
//setcookie ($configuracion["nombre"], $cadena, time()+$configuracion["tiempo"], $configuracion["carpeta"],$configuracion["dominio"],FALSE);
var_dump($_COOKIE);
echo("<br>");


/*
 * Eliminar
 * Para borrarlas todas las que tenemos
 * hacemos lo siguiente
 */
// unset cookies
/*
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-(3600*24*365),"/","www.cookie.net");
        //setcookie($name, '', time()-(3600*24*365),"/","www.cookie.net");
    }
}
*/

/*
 * BUSCAR
 * Para determinar las cookies que tenemos
 * y verlas todas hacemos lo siguiente
 */

/*
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name  = trim($parts[0]);
        $value = trim($parts[1]);
        echo ("El nombre de la cooki es: " .$name. " y el valor: " .urldecode($value).  "<br>" );
        //setcookie($name, '', time()-1000);
        //setcookie($name, '', time()-1000, '/');
    }
}
*/


/*
var_dump($_SERVER['HTTP_COOKIE']);
echo('<br>-------------------------------<br>');
$value = "cualquier cosa";
*/

//setcookie("TestCookie", $value);
// Para borrar la cookie
//setcookie("TestCookie", $value, 1);

/*
echo ('Todas las cookies valen: <br>');
print_r($_COOKIE);
echo('<br>-------------------------------<br>');

foreach($_COOKIE as $key=>$value){
    echo ("Key: " . $key . "value: " . $value . "<br>");
}

echo ('Nuestra cookie vale: <br>');
echo($_COOKIE["TestCookie"]);
echo('<br>-------------------------------<br>');

// Imprimir una cookie individual
echo $_COOKIE["TestCookie"];
*/

/*
 * Diversas cookies guardadas
 * en un array
 */

// crear las cookies
/*
setcookie("cookie[tres]", "cookietres");
setcookie("cookie[dos]", "cookiedos");
setcookie("cookie[uno]", "cookieuno");

// imprimirlas luego que la página es recargada
if (isset($_COOKIE['cookie'])) {
    foreach ($_COOKIE['cookie'] as $name => $value) {
        $name = htmlspecialchars($name);
        $value = htmlspecialchars($value);
        echo "$name : $value <br />\n";
    }
}
*/

/*
 * Para colocar varios valores en una
 * cookies desde un array.
 * 2 funciones. Primero construimos cookie
 * con el delimitador | y luego hacemos un explode
 */

function build_cookie($var_array) {
    $out = "";
    if (is_array($var_array)) {
        foreach ($var_array as $index => $data) {
            $out.= ($data!="") ? $index."=".$data.";" : "";
        }
    }
    return rtrim($out,"|");
}

function break_cookie ($cookie_string) {
    $array = explode(";",$cookie_string);
    foreach ($array as $i=>$stuff) {
        $stuff = explode("=",$stuff);
        $array[$stuff[0]]=$stuff[1];
        unset($array[$i]);
    }
    return $array;
}
?>