<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 08/07/2016
 * Time: 19:02
 */

/*
 * Descripción de todas las constantes
 * del programa
 */

/*
__LINE__	El número de línea actual en el fichero.
__FILE__	Ruta completa y nombre del fichero con enlaces simbólicos resueltos. Si se usa dentro de un include, devolverá el nombre del fichero incluido.
__DIR__		Directorio del fichero. Si se utiliza dentro de un include, devolverá el directorio del fichero incluído. Esta constante es igual que dirname(__FILE__). El nombre del directorio no lleva la barra final a no ser que esté en el directorio root.
__FUNCTION__	Nombre de la función.
__CLASS__	Nombre de la clase. El nombre de la clase incluye el namespace declarado en (p.e.j. Foo\Bar). Tenga en cuenta que a partir de PHP 5.4 __CLASS__ también funciona con traits. Cuando es usado en un método trait, __CLASS__ es el nombre de la clase del trait que está siendo utilizado.
__TRAIT__	El nombre del trait. El nombre del trait incluye el espacio de nombres en el que fue declarado (p.e.j. Foo\Bar).
__METHOD__	Nombre del método de la clase.
__NAMESPACE__	Nombre del espacio de nombres actual.
*/

echo ("-------------- Displaiamos todas las constantes del sistema en el fichero raiz ------------<br>");
echo ("Linia: " . __LINE__ . "<br>");
echo ("File: " . __FILE__ . "<br>");
echo ("Dir: " . __DIR__ . "<br>");
echo ("Function : " . __FUNCTION__ . "<br>");
echo ("Clase : " . __CLASS__ . "<br>");
echo ("Trait : " . __TRAIT__ . "<br>");
echo ("Method : " . __METHOD__ . "<br>");
echo ("Namespace : " . __NAMESPACE__ . "<br>");
echo ("-------------- Fin ------------<br>");


function funcion(){
    echo ("-------------- Displaiamos todas las constantes del sistema dentro de la funcion llamada funcion ------------<br>");
    echo ("Linia: " . __LINE__ . "<br>");
    echo ("File: " . __FILE__ . "<br>");
    echo ("Dir: " . __DIR__ . "<br>");
    echo ("Function : " . __FUNCTION__ . "<br>");
    echo ("Clase : " . __CLASS__ . "<br>");
    echo ("Trait : " . __TRAIT__ . "<br>");
    echo ("Method : " . __METHOD__ . "<br>");
    echo ("Namespace : " . __NAMESPACE__ . "<br>");
    echo ("-------------- Fin ------------<br>");
}

funcion();

class Clase{
    public function __construct()
    {
        echo ("-------------- Construimos clase llamada Clase ------------<br>");
    }
    public function printear(){
        echo ("-------------- Displaiamos todas las constantes del sistema dentro de la funcion llamada funcion ------------<br>");
        echo ("Linia: " . __LINE__ . "<br>");
        echo ("File: " . __FILE__ . "<br>");
        echo ("Dir: " . __DIR__ . "<br>");
        echo ("Function : " . __FUNCTION__ . "<br>");
        echo ("Clase : " . __CLASS__ . "<br>");
        echo ("Trait : " . __TRAIT__ . "<br>");
        echo ("Method : " . __METHOD__ . "<br>");
        echo ("Namespace : " . __NAMESPACE__ . "<br>");
        echo ("-------------- Fin ------------<br>");
    }
}
$objeto = new Clase();
$objeto->printear();

