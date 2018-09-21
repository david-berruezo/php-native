<?php
/*
 * Primero explode de una imagen por el "."
 * Luego array_pop por un lado y array_shift por otro
 * total == array_pop === coge extension y arra_shift coge la iamgen
 */
$imagen_and_extension = "hola.jpg";
$imagen_and_extension_vector = explode(".",$imagen_and_extension);
$extension = array_pop($imagen_and_extension_vector);
$imagen    = array_shift($imagen_and_extension_vector);
echo "La iamgen es: ".$imagen." y la extensión es: ".$extension."<br>";
?>