<?php
/**
 * David Berruezo
 * Aplicación Vinos
 */
require_once "vendor\autoload.php";
use clases\Ferreteria;
$ferreteria = new Ferreteria();
$ferreteria->getCategories("left-nav");
$ferreteria->getImagesCategories();
/*
$ferreteria->getProductList();
$ferreteria->getDetailProduct();
$ferreteria->writeProductToCsv();
*/
?>