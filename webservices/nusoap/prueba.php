<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 30/06/2016
 * Time: 16:09
 */
include_once('lib/nusoap.php');
$url       = "http://localhost/prueba/php/webservices/nusoap/prueba.php";
$servicio  = new nusoap_server();
$servicio->configureWSDL('consulta',$url);
$servicio->wsdl->schemaTargetNamespace = $url;
$servicio->soap_defencoding            = 'utf-8';
$servicio->register("listarCursos",array('miparametro'=>'xsd:string'),array('return' => 'xsd:string'),$url);

function listarCursos($miparametro){
    $resultado = "Mi parametro recibido es: ".$miparametro;
    //return ($resultado);
    return new soapval('return','xsd:string',$resultado);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA: '';
$servicio->service($HTTP_RAW_POST_DATA);