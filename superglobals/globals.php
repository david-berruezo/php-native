<?php
namespace Proyecto\Superglobals;
/*
 * Ejemplo 1
 * Acceso  variables
 */
function test() {
    $foo = "local variable";
    //echo '$foo in global scope: ' . $GLOBALS["foo"] . "\n";
    //echo '$foo in current scope: ' . $foo . "\n";
    //echo '$foo in current scope: ' . $foo . "\r";
    var_dump($GLOBALS['var1']);
    echo("<br>");
    var_dump($GLOBALS['_GET']);
    echo("<br>");
    //var_dump($GLOBALS['GLOBALS']);
    foreach($GLOBALS as $key=>$value){
        //echo "key: " .$key. "value: " . $value. "\n" ;
    }
}
$foo  = "Example content";
$var1 = 'hola1';
$var2 = 'hola2';
$var3 = 'hola3';
test();


/*
 * Ejemplo 2
 * Se hace una referencia de una variable de globals
 * y en cambio en post es imposible
 */

// Testing $_POST
$_POST['A']                 = 'B';
$nonReferencedPostVar       = $_POST;
$nonReferencedPostVar['A']  = 'C';
echo 'POST: '.$_POST['A'].', Variable: '.$nonReferencedPostVar['A']."<br>\n";
// Testing Globals
$GLOBALS['A'] = 'B';
$nonReferencedGlobalsVar = $GLOBALS;
$nonReferencedGlobalsVar['A'] = 'C';
echo 'GLOBALS: '.$GLOBALS['A'].', Variable: '.$nonReferencedGlobalsVar['A']."\<br>\n";
?>