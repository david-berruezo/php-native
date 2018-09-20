<?php
/*
 * Primero incluimos el fichero con include en
 * la ruta include_path de php.ini en este
 * caso esta c:/php7.0.8/include
 */

include("fichero.php");

/*
 * Cambiamos el include path
 */

set_include_path("c:/htdocs/prueba/php/include");
include("fichero.php");

/*
 * Si queremos cambiar el include_path del
 * php.ini lo cambiaremos mediante la
 * función set_include_path
 */
ini_set('include_path', '../');
include("fichero.php");


/*
 * Referente a la no inclusión primero
 * y a la inclusión después del fichero que se
 * llama variables
 */
echo "Una $fruta $color"; // Una
include 'include/variables.php';
echo "Una $fruta $color<br>"; // Una manzana verde

/*
 * Ahora vamos a hacer un include dentro
 * de una función y luego intentaremos acceder
 * a las variables, algunas de ellas con ambito
 * global y otras no
 */

function foo()
{
    global $animal;
    include "include/variables1.php";
    echo "Una $animal $raza<br>";
}

/* vars.php está en el ámbito de foo() así que *
* $fruta NO está disponible por fuera de éste  *
* ámbito. $color sí está porque fue declarado *
* como global.                                 */

foo();                          // Una manzana verde
echo "Una $animal $raza<br>";   // Una verde

