<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 8:15
 */
require_once "vendor/autoload.php";
use clases\CD;
$boughtCDs   = array();
$boughtCDs[] = array("band" => "Isabel Pantoja", "title" => "Marinero de Luces");
$boughtCDs[] = array("band" => "Manolo Escobar", "title" => "Mi carro me lo robaron");
$boughtCDs[] = array("band" => "Miguel Bose", "title"    => "Morena mia");
var_dump($boughtCDs);
foreach ($boughtCDs as $boughtCD) {
    $cd = new CD($boughtCD["title"], $boughtCD["band"]);
    $cd->buy();
}
?>