<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 01/07/2016
 * Time: 17:49
 */
$jugo = "manzana";
echo "Él tomó algo de jugo de $jugo.".PHP_EOL;
// Inválido. "s" es un carácter válido para un nombre de variable, pero la variable es $jugo.
echo "Él tomó algo de jugo hecho de $jugos.";
// Válido. Explícitamente especifica el final del nombre de la variable encerrándolo entre llaves:
echo "Él tomó algo de jugo hecho de ${jugos}s.";
echo('<br>--------------<br>');
echo('<br>');
$jugos = array("manzana", "naranja", "koolaid1" => "púrpura");
echo "Él tomó algo de jugo de $jugos[0].".PHP_EOL;
echo "Él tomó algo de jugo de $jugos[1].".PHP_EOL;
echo "Él tomó algo de jugo $jugos[koolaid1].".PHP_EOL;
echo('<br>--------------<br>');
echo('<br>');
class persona {
    public $john = "John Smith";
    public $jane = "Jane Smith";
    public $robert = "Robert Paulsen";

    public $smith = "Smith";
}
$persona = new persona();
echo "$persona->john tomó algo de jugo de $jugos[0].".PHP_EOL;
echo "$persona->john entonces dijo hola a $persona->jane.".PHP_EOL;
echo "La esposa de $persona->john saludó a $persona->robert.".PHP_EOL;
echo "$persona->robert saludó a los dos $persona->smith."; // No funcionará
echo "$persona->robert saludó a los dos $persona->smiths."; // No funcionará


// Mostrar todos los errores
error_reporting(E_ALL);
$genial = 'fantástico';
// No funciona, muestra: Esto es { fantástico}
echo "Esto es { $genial}";
// Funciona, muestra: Esto es fantástico
echo "Esto es {$genial}";
// Funciona
echo "Este cuadrado tiene {$cuadrado->width}00 centímetros de lado.";
// Funciona, las claves entre comillas sólo funcionan usando la sintaxis de llaves
echo "Esto funciona: {$arr['clave']}";
// Funciona
echo "Esto funciona: {$arr[4][3]}";
// Esto no funciona por la misma razón que $foo[bar] es incorrecto fuera de un string.
// En otras palabras, aún funcionaría, pero solamente porque PHP primero busca una
// constante llamada foo; se emitirá un error de nivel E_NOTICE
// (constante no definida).
echo "Esto está mal: {$arr[foo][3]}";
// Funciona. Cuando se usan arrays multidimensionales, emplee siempre llaves que delimiten
// a los arrays cuando se encuentre dentro de un string
echo "Esto funciona: {$arr['foo'][3]}";
// Funciona.
echo "Esto funciona: " . $arr['foo'][3];
echo "Esto también funciona: {$obj->valores[3]->nombre}";
echo "Este es el valor de la variable llamada $nombre: {${$nombre}}";
echo "Este es el valor de la variable llamada por el valor devuelto por getNombre(): {${getNombre()}}";
echo "Este es el valor de la variable llamada por el valor devuelto por \$objeto->getNombre(): {${$objeto->getNombre()}}";
//No funciona, muestra: Esto es el valor devuelto por getNombre(): {getNombre()}
echo "Esto es el valor devuelto por getNombre(): {getNombre()}";

class foo {
    var $bar = 'Soy bar.';
}

$foo = new foo();
$bar = 'bar';
$baz = array('foo', 'bar', 'baz', 'quux');
echo "{$foo->$bar}\n";
echo "{$foo->{$baz[1]}}\n";

?>