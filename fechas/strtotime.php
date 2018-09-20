<?php
/**
 * Algoritmo conflicto.
 * de fechas
 */

/*
 * Definimos comienzo dia a las 6:00H
 * Definimos final del dia  las 24:00H
 */
error_reporting(1);

echo "--------- Todos los registros ----------<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484478000)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484478180)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484564400)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484564580)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484650800)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484650980)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484737200)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484737380)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484823600)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484823780)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484910000)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484910180)."<br>";
echo "am7: ".date("Y-m-d H:i:s", 1484996400)."<br>";
echo "pm7: ".date("Y-m-d H:i:s", 1484996580)."<br>";

echo "Que es: ".date("Y-m-d H:i:s", 1484478000)."<br>";
echo "Que es: ".date("Y-m-d H:i:s", 1484737200)."<br>";
echo "Que es: ".date('w', 1484737200)."<br>";


echo "En horas minutos segundos<br>";
echo ("start_time: ".date("Y-m-d H:i:s", 1484046000)."<br>");
echo ("end_time: ".date("Y-m-d H:i:s", 1484046060)."<br>");
echo ("start_time: ".date("Y-m-d H:i:s", 1484046060)."<br>");
echo ("end_time: ".date("Y-m-d H:i:s", 1484046120)."<br>");
echo"<br><br>";

echo "Otros<br>";
echo ("start_time: ".date("Y-m-d H:i:s", 1485255600)."<br>");
echo ("end_time: ".date("Y-m-d H:i:s", 1485255660)."<br>");
echo ("start_time: ".date("Y-m-d H:i:s", 1485255720)."<br>");
echo ("end_time: ".date("Y-m-d H:i:s", 1485255780)."<br>");
echo"<br><br>";


/*
 * Las reservas de mrbs entry
 */
echo "En horas minutos segundos<br>";
echo ("entrada 09:00: ".date("Y-m-d H:i:s", 1485255600)."<br>");
echo ("salida 09:00: ".date("Y-m-d H:i:s", 1485255660)."<br>");
echo ("entrada 15:30: ".date("Y-m-d H:i:s", 1485255720)."<br>");
echo ("salida: 15:30:".date("Y-m-d H:i:s", 1485255780)."<br>");
echo"<br><br>";

/*
 * 3 dias de 6:00 a 24:00
 */
echo "----------- 3 dias consecutivos ------------<br>";
$tiempo   = '2017-01-23 06:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-23 24:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-21 06:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-21 23:59:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-22 06:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-22 23:59:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

echo "----------- fin dias consecutivos ------------<br>";

echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1486357200)."<br>");
echo (date("Y-m-d H:i:s", 1486421940)."<br>");

echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1486443600)."<br>");
echo (date("Y-m-d H:i:s", 1486508340)."<br>");

echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1486530000)."<br>");
echo (date("Y-m-d H:i:s", 1486594740)."<br>");

echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1486616400)."<br>");
echo (date("Y-m-d H:i:s", 1486681140)."<br>");

echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1486702800)."<br>");
echo (date("Y-m-d H:i:s", 1486767540)."<br>");

$tiempo   = '2017-01-25 06:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-25 23:59:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br><br><br><br>");


$tiempo   = '2017-01-22 23:59:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

echo ("<br><br><br>");

// Diferencia 12 horas
$tiempo   = '2017-01-10 6:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-10 24:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");
echo"<br><br>";

echo "La buena dia 11:<br>";
$tiempo   = '2017-01-11 6:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-11 24:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

echo "La buena dia 10:<br>";
$tiempo   = '2017-01-10 6:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-10 24:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

echo"<br><br>";

// Diferencia 12 horas
$tiempo   = '2017-01-11 12:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-11 24:00:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

// 12 horas
// 43200
echo"<br><br>";

/*
$tiempo = '2017-01-10 09:00:00';
$miTiempo = strtotime($tiempo);
echo "mi tiempo es: ".$miTiempo."<br>";
$tiempo = '2017-01-10 10:00:00';
$miTiempo = strtotime($tiempo);
echo "mi tiempo es: ".$miTiempo."<br>";
echo (date("H:i:s", 1484046000)."<br>");
echo (date("H:i:s", 1484046060)."<br>");
*/

$tiempo   = '2017-01-11 15:30:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

$tiempo   = '2017-01-11 15:31:00';
$miTiempo = strtotime($tiempo);
echo ($miTiempo."<br>");

echo "<br><br>";
// primera reserva
echo "En horas minutos segundos<br>";
echo (date("Y-m-d H:i:s", 1484132400)."<br>");
echo (date("Y-m-d H:i:s", 1484132460)."<br>");
// segunda reserva
echo (date("Y-m-d H:i:s", 1484132460)."<br>");
echo (date("Y-m-d H:i:s", 1484132520)."<br>");
// tercera reserva
echo (date("Y-m-d H:i:s", 1484132520)."<br>");
echo (date("Y-m-d H:i:s", 1484132580)."<br>");

// Primera reserva
// 2017-01-11 12:00:00
// 2017-01-11 12:01:00

// Segunda reserva
// 2017-01-11 12:01:00
// 2017-01-11 12:02:00

// Tercera reserva
// 2017-01-11 12:02:00
// 2017-01-11 12:03:00

// tercera reserva
echo (date("Y-m-d H:i:s", 1484219040)."<br>");
echo (date("Y-m-d H:i:s", 1484219100)."<br>");

//2017-01-12 12:04:00
//2017-01-12 12:05:00


try {
    $usuario        = "root";
    $contraseña     = "Berruezin23";
    $conexion = new PDO('mysql:host=localhost;dbname=mrbsperiodosbuenos', $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    //die();
}

$query = "SELECT pfechas.id, pfechas.fecha, pfechas.start_fecha, pfechas.end_fecha
FROM mrbs_periodos_fechas as pfechas
LEFT JOIN mrbs_periodos_horas_motoristas as pfechasmotoristas
ON pfechasmotoristas.id_periodos_fecha = pfechas.id";
//WHERE pfechas.start_fecha < :fin
//AND pfechas.end_fecha > :inicio
$inicio       = "2017-01-10 09:59:00";
$fin          = "2017-01-10 11:00:00";
$inicio       = (int)strtotime($inicio);
$fin          = (int)strtotime($fin);
//echo "inicio: ".$inicio."<br>";
//echo "fin: ".$fin."<br>";
$stmt         = $conexion->prepare( $query );
//$stmt->bindParam(':inicio', $inicio,PDO::PARAM_INT);
//$stmt->bindParam(':fin', $fin,PDO::PARAM_INT);
$stmt->execute();
$encontrado = false;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    var_dump($row);
    if($inicio > $row["start_fecha"] && $fin < $row["end_fecha"])
        $encontrado =  true;
    if($inicio < $row["start_fecha"] && $fin < $row["end_fecha"] && $fin > $row["start_fecha"])
        $encontrado =  true;
    if($inicio < $row["start_fecha"] && $fin > $row["end_fecha"])
        $encontrado =  true;
    if($inicio > $row["start_fecha"] && $fin > $row["end_fecha"] && $inicio < $row["end_fecha"])
        $encontrado =  true;
    if($inicio == $row["start_fecha"] && $fin > $row["end_fecha"])
        $encontrado =  true;
    if($inicio == $row["start_fecha"] && $fin < $row["end_fecha"])
        $encontrado =  true;
    if($inicio > $row["start_fecha"] && $fin == $row["end_fecha"])
        $encontrado =  true;
    if($inicio < $row["start_fecha"] && $fin == $row["end_fecha"])
        $encontrado =  true;
}
echo $encontrado;
?>