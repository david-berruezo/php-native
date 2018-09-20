<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 12:24
 */

/*
 * Devuelve 1 en caso de coincidencia
 * o 0 en caso de no coincidencia
 */

$cadena     = 'From Alejandro,the Subject is estudiar';
$resultado  = preg_match ("[^(From|Subject)]", $cadena);
if ($resultado){
    echo('Encontrado:'.$resultado.'<br>');
}else{
    echo('No encontrado:'.$resultado.'<br>');
}

$cadena     = 'I will go to vacation next year';
$cadena1    = 'cation I will go to next year';
$cadena2    = 'I will go to next year cat';
$cadena3    = 'cat';
$cadena4    = 'La pea de la pua esta malita';
$cadena5 = <<<EOD
<h1>Titulo 1</h1>
<h2>Titulo 1</h2>
<h3>Titulo 1</h3>
<h4>Titulo 1</h4>
<h5>Titulo 1</h5>
<h6>Titulo 1</h6>
EOD;
$cadena6     = 'Hola Mr.Smith';
$cadena7     = '6Que bueno';
$cadena8     = '07/04/76,07-04-76,07.04.76';
$cadena9     = 'Qawai';
$cadena10    = 'Bob y Robert salen de copas';

$resultado  = preg_match ("(cat)", $cadena);
$resultado1 = preg_match ("(^cat)", $cadena1);
$resultado2 = preg_match ("(cat$)", $cadena2);
$resultado3 = preg_match ("(^cat$)", $cadena3);
$resultado4 = preg_match ("[p[ue]a]", $cadena4);

if ($resultado){
    echo('Encontrado Cat en medio de la cadena:'.$resultado.'<br>');
}else{
    echo('No encontrado Cat en medio de la cadena:'.$resultado.'<br>');
}

if ($resultado1){
    echo('Encontrado Cat al principio de la cadena:'.$resultado1.'<br>');
}else{
    echo('No encontrado Cat al principio de la cadena:'.$resultado1.'<br>');
}

if ($resultado2){
    echo('Encontrado Cat al final de la cadena:'.$resultado2.'<br>');
}else{
    echo('No encontrado Cat al final de la cadena:'.$resultado2.'<br>');
}

if ($resultado3){
    echo('Encontrado Cat al principio y final de la cadena:'.$resultado3.'<br>');
}else{
    echo('No Encontrado Cat al principio y final de la cadena:'.$resultado3.'<br>');
}

if ($resultado4){
    echo('Encontrado pea y pua:'.$resultado4.'<br>');
}else{
    echo('No encontrado pea y pua:'.$resultado4.'<br>');
}

$resultado5 = preg_match ("[<h[123456]>]", $cadena5);
if ($resultado5){
    echo("Encontrado $cadena5:<br>".$resultado5.'<br>');
}else{
    echo("No encontrado $cadena5:<br>".$resultado5.'<br>');
}

$resultado6 = preg_match ("[[Ss]mith]", $cadena6);
if ($resultado6){
    echo('Encontrado Smith:'.$resultado6.'<br>');
}else{
    echo('No encontrado Smith:'.$resultado6.'<br>');
}

$resultado7 = preg_match ("[<[Hh][1-6]>]", $cadena5);
if ($resultado7){
    echo("Encontrado $cadena5 con h1-h6 utilizando guión como rango de carácteres:".$resultado7.'<br>');
}else{
    echo("No encontrado $cadena5 con h1-h6 utilizando guión como rango de carácteres:".$resultado7.'<br>');
}

$resultado8 = preg_match ("[^[1-6]]", $cadena7);
if ($resultado8){
    echo("Encontrado $cadena7 del 1 al 6:".$resultado8.'<br>');
}else{
    echo("No encontrado $cadena7 del 1 al 6:".$resultado8.'<br>');
}

// La negacion ^ que es lo mismo que empezar cadena
$resultado9 = preg_match ("[^1-6]", $cadena7);
if ($resultado9){
    echo("Encontrado $cadena7 del 1 al 6:".$resultado9.'<br>');
}else{
    echo("No encontrado $cadena7 del 1 al 6:".$resultado9.'<br>');
}

//  Búsqueda por fechas
// '07/04/76,07-04-76,07.04.76
$resultado10 = preg_match ("[07[/.-]04[/.-]76]", $cadena8);
if ($resultado10){
    echo("Encontrado $cadena8 del 1 al 6:".$resultado10.'<br>');
}else{
    echo("No encontrado $cadena8 del 1 al 6:".$resultado10.'<br>');
}

// Solo encuentra palabras que empiezen por Qq y que nieguen u o sean diferentes de u que es lo mismo
$resultado11 = preg_match ("[[Qq][^u]]", $cadena9);
if ($resultado11){
    echo("Encontrado $cadena9 Qawai:".$resultado11.'<br>');
}else{
    echo("No encontrado $cadena9 Qawai:".$resultado11.'<br>');
}

// Encuentra Bob o Robert
$resultado12 = preg_match ("[Bob|Robert]", $cadena10);
if ($resultado12){
    echo("Encontrado $cadena10 Bob o Robert:".$resultado12.'<br>');
}else{
    echo("No encontrado $cadena10 Qawai:".$resultado12.'<br>');
}



$subject = '<p>Hola pepe</p><h4 class="pedro">papa</h4>';
$pattern = '/<([A-Z][A-Z0-9]*)\b[^>]*>.*?</\1>/';
preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);
var_dump($matches);

