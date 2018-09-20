<?php
/**
 * David Berruezo.
 */
require_once "vendor/autoload.php";
use clases\CDFactory;

/*
 * Creamos primer CD
 */
$title = 'Mi carro me lo robaron';
$band  = 'Manolo Escobar';
$tracksFromExternalSource = array('El beso en España', 'Porompompero', 'A Barcelona');
$type = "Cd";
$cd   = CDFactory::create($type);
$cd->setTitle($title);
$cd->setBand($band);
foreach ($tracksFromExternalSource as $track) {
    $cd->addTrack($track);
}
echo "Primer objeto creado<br>";
var_dump($cd);
echo "<br><br><br>";

/*
 * Creamos el segundo cd
 */
$title = 'Marinero de luces';
$band  = 'Isabel Pantoja';
$tracksFromExternalSource = array('Marinero de luces', 'Bamboleo', 'Baila morena');
$type  = "cdmejorado";
$cd    = CDFactory::create($type);
$cd->setBand($band);
$cd->setTitle($title);
foreach ($tracksFromExternalSource as $track) {
    $cd->addTrack($track);
}
echo "Segundo objeto mejorado creado<br>";
var_dump($cd);
?>