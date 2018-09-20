<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/06/2016
 * Time: 15:09
 */
error_reporting(E_ALL);
function incrementar(&$var)
{
    $var++;
}

$a = 0;
call_user_func('incrementar', $a);
echo $a."\n";

// En su lugar se puede usar esto
//call_user_func_array('incrementar', array(&$a));
//echo $a."\n";
?>