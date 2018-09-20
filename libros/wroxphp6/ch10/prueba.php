<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 30/06/2016
 * Time: 18:26
 */


if (!extension_loaded('openssl')) {
    // no openssl extension loaded.
    echo('Hola');
}

$client = new SoapClient(null,array(
    'location' => 'http://localhost/wroxphp6/ch10/prueba.php',
    'uri' => 'http://my_uri/',
    'style' => SOAP_RPC,
    'use' => SOAP_ENCODED
));
