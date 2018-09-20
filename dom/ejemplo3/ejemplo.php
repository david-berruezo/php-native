<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 19/08/2016
 * Time: 15:33
 */
require_once "HTMLPP.php";                      /*include the file*/
$HTML=new HTMLPP;                               /*Create the instance*/
$HTML->loadHTMLFile("http://www.vinoseleccion.com/regiones/ribera-del-duero");    /*Load the code*/
$document=& $HTML->getDocument();
echo $document;
?>