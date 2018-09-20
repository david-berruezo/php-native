<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/12/16
 * Time: 20:03
 */
include_once("vendor/autoload.php");
use clases\ObjetoXml;
$objetoXml = new ObjetoXml();
$objetoXml->leerXml();
$objetoXml->writeCsv();
?>