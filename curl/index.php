<?php
/**
 * David Berruezo
 * Aplicación Vinos
*/
require_once "vendor\autoload.php";
use clases\Vino;
$vino = new Vino();
$vino->getPages("pages");
$vino->getProductList();
$vino->getProductDetail();
$vino->writeCsv();
?>

