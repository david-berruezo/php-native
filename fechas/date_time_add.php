<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/07/2016
 * Time: 18:49
 */

/*
 * En este ejemplo añadimos
 * 10 dias al intervalo
 */
$fecha = new DateTime('2000-01-01');
// Añadimos 10 dias
$fecha->add(new DateInterval('P10D'));
echo $fecha->format('Y-m-d') . "\n" . "<br>";

/*
 * En este ejemplo añadimos 10 horas
 * y 30 segundos
 * Y luego añadimos 7 años 5 meses 4 dias, 4h 3 minutos, 2 segundos
 */
$fecha= new DateTime('2000-01-01');
$fecha->add(new DateInterval('PT10H30S'));
echo $fecha->format('Y-m-d H:i:s') . "\n" ."<br>";

$fecha = new DateTime('2000-01-01');
$fecha->add(new DateInterval('P7Y5M4DT4H3M2S'));
echo $fecha->format('Y-m-d H:i:s') . "\n" . "<br>";

/*
 * En este ejemplo añadimos meses
 */
$fecha = new DateTime('2000-12-31');
$intervalo = new DateInterval('P1M');

$fecha->add($intervalo);
echo $fecha->format('Y-m-d') . "\n";

$fecha->add($intervalo);
echo $fecha->format('Y-m-d') . "\n";


/*
 * Convertir fechas
 * meses numeros en letras
 *
 */
$dia      = 01;
$mes      = "Aug";
$year     = 2016;
$fecha    = $dia.'-'.$mes.'-'.$year;
echo "La fecha es: ".$fecha."<br>";
$monthNum = 5;
//Y-m-d
$fecha = DateTime::createFromFormat('d-M-Y', $fecha);
var_dump($fecha);
$fecha->format('Y-m-d');
echo "La fecha convertida es: ".$fecha->date."<br>";
/*
var_dump($fecha);
var_dump($fecha->format('Y-m-d'));
*/
//echo "La fecha introducida es: ".$fecha."<br>";
//echo "La fecha convertida es: ".$fecha->format('Y-m-d')."<br>";
?>