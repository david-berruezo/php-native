<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 11:14
 */

$varfichero2 = "ok";
if (isset($GLOBALS["varfichero2"])) {
    echo "varfichero2 is in global scope.\n";
} else {
    echo "varfichero2 is NOT in global scope.\n";
}
unset($varfichero2);