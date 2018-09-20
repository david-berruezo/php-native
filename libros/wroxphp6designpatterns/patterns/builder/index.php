<?php
include_once ("vendor/autoload.php");
use clases\Product;
use clases\ProductBuilder;

/*
 * Design pattern builder to create objects
 */
$productConfigs = array("type"=>"shirt","size"=>"XL","color"=>"red");
$builder = new ProductBuilder($productConfigs);
$builder->build();
$product = $builder->getProduct();
print_r($product);
echo "<br>";

/*
 * Normal way
 */
// our product configuration received from other functionality
$productConfigs = array("type"=>"pants","size"=>"XL","color"=>"red");
$product = new product();
$product->setType($productConfigs["type"]);
$product->setSize($productConfigs["size"]);
$product->setColor($productConfigs["color"]);
print_r($product);
echo "<br>";
?>