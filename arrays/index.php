<?php 

/*
 * Combine, Keys, values
 * 
 */

$keys      = ['madrid', 'paris', 'roma'];
$values    = ['españa', 'francia', 'italia'];

// Combine
$paises_capitales = array_combine($keys,$values);

// Values
$capitales = array_keys($paises_capitales);
$paises    = array_values($paises_capitales);

echo "Paises y capitales: ";
print_r($paises_capitales);
echo "<br>";
echo "Paises: ";
print_r($paises);
echo "<br>";
echo "Capitales: ";
print_r($capitales);
echo "<br>";

list($pais1,$pais2,$pais3) = $keys;
echo "Capital 1: ".$pais1." Capital 2:".$pais2." Capital 3:".$pais3."<br>";


// Cambiamos claves por valores
$capitales_paises = array_flip($paises_capitales);
echo "Capitales y paises: ";
print_r($capitales_paises);




/*
 * Divide array into parts
 * as array_chunk
 */

 /*
function partition( $list, $p ) {
    $listlen = count( $list );
    $partlen = floor( $listlen / $p );
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}

$citylist = array( "Black Canyon City", "Chandler", "Flagstaff", "Gilbert", "Glendale", "Globe", "Mesa", "Miami","Phoenix", "Peoria", "Prescott", "Scottsdale", "Sun City", "Surprise", "Tempe", "Tucson", "Wickenburg" );
$partition = partition( $citylist, 3 );
foreach($partition as $part){
    print_r($part);
    echo "<br>";
}
echo '<br><br><br>';
*/

/**
 * Ejemplo 1
 * No hay array merge
 */

/*
$default_server_values = array(
    'SERVER_SOFTWARE' => '',
    //'REQUEST_URI' => '',
);

echo ('********************** Datos de server ********************<br>');
while(list($key,$value) = each($_SERVER)){
    echo('Key: '.$key.' Value: '.$value.'<br>');
}
echo ('***********************************************************<br>');
echo('phpself: '.$_SERVER['PHP_SELF'].'<br>');
$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
echo('phpself: '.$_SERVER['PHP_SELF'].'<br>');
var_dump($_SERVER);
*/


/*
 * Primero explode de una imagen por el "."
 * Luego array_pop por un lado y array_shift por otro
 * total == array_pop === coge extension y arra_shift coge la iamgen
 */

/*
$imagen_and_extension = "hola.jpg";
$imagen_and_extension_vector = explode(".",$imagen_and_extension);
$extension = array_pop($imagen_and_extension_vector);
$imagen    = array_shift($imagen_and_extension_vector);
echo "La iamgen es: ".$imagen." y la extensión es: ".$extension."<br>";


$content   = array();
$productos = array();
$resto     = array();
for ($i=0;$i<20500;$i++){
   $producto           = array();
   $producto["id"]     = $i;
   $producto["nombre"] = "Producto ".$i;
   array_push($content,"contenido".$i);
   array_push($productos,$producto);
}
//var_dump($content);
//var_dump($productos);
//$porcion  = count($productos) / 20;
//$fraction = count($productos) - ($porcion * 20); // .25
for ($i=0;$i<20;$i++){
    $output = array_slice($productos,$i*1000, 1000);
    mostrarMil($output);
}
mostrarResto($productos);
function mostrarMil($productos){
    var_dump($productos);
}
function mostrarResto($productos){
    global $resto;
    for ($i=1000*20;$i<count($productos);$i++){
        array_push($resto,$productos[$i]);
    }
}
var_dump($resto);
*/

/*
$input = array("a", "b", "c", "d", "e");
$len = count($input);
$firsthalf = array_slice($input, 0, $len / 2);
$secondhalf = array_slice($input, $len / 2);
*/

/*
$keys      = ['madrid', 'paris', 'roma'];
$values    = ['españa', 'francia', 'italia'];

// Combine
$paises    = array_combine($keys,$values);

// Values
$capitales = array_keys($keys);
$paises    = array_values($values);
list($capital1,$capital2,$capital3) = $keys;
// Multidimensional
$arrays = [[1, 2], [3, 4], [5, 6]];
foreach ($arrays as list($a, $b)) {
    $c = $a + $b;
    echo($c . ', '); // 3, 7, 11,
}

$string = 'hello|wild|world';
list($hello, , $world) = explode('|', $string);
echo("$hello, $world"); // hello, world

$array = [
    'clothes' => 't-shirt',
    'size'    => 'medium',
    'color'   => 'blue',
];

extract($array);
echo("$clothes $size $color"); // t-shirt medium blue

$clothes = 't-shirt';
$size    = 'medium';
$color   = 'blue';

$array = compact('clothes','size', 'color');
print_r($array);

// Array
// (
//     [clothes] => t-shirt
//     [size] => medium
//     [color] => blue
// )

$vector = array(
    'http://www.ferreteria.net/sartenes/packs-especiales/packs-castey/pack-saludable-castey-yellow.html',
    'http://www.ferreteria.net/sartenes/sartenes-de-induccion/sarten-castey-induccion-26cm.htm'
);
foreach($vector as $url){
    $urlSinDominio = str_replace('http://www.ferreteria.net/'," ",$url);
    $carpetas      = explode("/",$urlSinDominio);
    var_dump($carpetas);
}

$numbers = array(8,23,15,42,16,4);
print_r($numbers);
echo"<br>";
echo "Count: ".count($numbers)."<br>";
echo "Max: ".max($numbers)."<br>";
echo "Min: ".min($numbers)."<br>";
sort($numbers);
echo "Sort: ".print_r($numbers)."<br>";
rsort($numbers);
echo "Rverse Sort: ".print_r($numbers)."<br>";
$num_string = implode(" * ",$numbers);
echo "Strings numbers with implode: ".$num_string."<br>";
$num_array();
*/
?>