<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 11:11
 */

$varfichero3 = "ok";
if (isset($GLOBALS["varfichero3"])) {
    echo "varfichero3 is in global scope.\n";
} else {
    echo "varfichero3 is NOT in global scope.\n";
}
unset($varfichero3);