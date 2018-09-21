<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 22/08/2016
 * Time: 10:38
 */
$vector  = array("valor1","valor2","valor3");
$vector1 = ["valor1","valor2","valor3"];
var_dump($vector);
var_dump($vector1);

echo $vector1;

function fix_string($a)
{
    echo "Called @ ".
        xdebug_call_file().
        ":".
        xdebug_call_line().
        " from ".
        xdebug_call_function();
}
$ret = fix_string(array('Derick'));
?>

