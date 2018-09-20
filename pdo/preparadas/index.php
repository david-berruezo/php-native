<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 10/07/2016
 * Time: 12:27
 */

/*
 *  Conectamos a la base de datos
 */
try {
    $usuario    = "root";
    $contraseña = "Berruezin23";
    $dbh        = new PDO('mysql:host=localhost;dbname=davidber_web', $usuario, $contraseña,array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

/*
 * Preparamos la sentencia 1
 * campos: artist, title
 * Ejemplo 1
 */
/*
$sentencia = $dbh->prepare("INSERT INTO album (artist,title) VALUES (:artist, :title)");
$sentencia->bindParam(':artist', $artist);
$sentencia->bindParam(':title', $title);
// insertar una fila
$artist = "David";
$title  = "Album David";
$sentencia->execute();
// insertar otra fila con diferentes valores
$artist = "Antonio";
$title  = "Album Antonio";
$sentencia->execute();
// insertar otra fila con diferentes valores
$artist = "Dolores";
$title  = "Album Dolores";
$sentencia->execute();
*/

/*
 * Preparamos la sentencia 2
 * campos: nombre
 * Ejemplo 1.2
 */

/*
$sentencia1 = $dbh->prepare("INSERT INTO prueba (nombre) VALUES (:nombre)");
$sentencia1->bindParam(':nombre', $nombre);
// insertar una fila
$nombre = "David";
$sentencia1->execute();
// insertar otra fila con diferentes valores
$nombre = "Antonio";
$sentencia1->execute();
// insertar otra fila con diferentes valores
$nombre = "Dolores";
$sentencia1->execute();
*/

/*
 * Preparamos la sentencia 3
 * campos: artist, title PERO NO LOS ESPECIFICAMOS usamos ??
 * Ejemplo 3
 */
/*
$sentencia2 = $dbh->prepare("INSERT INTO album (artist, title) VALUES (?, ?)");
$sentencia2->bindParam(1, $artist);
$sentencia2->bindParam(2, $titulo);

// insertar una fila
$artist = 'Andreu';
$titulo = "Andreu Album";
$sentencia2->execute();
*/

/*
 * Preparamos la sentencia 4
 * campos: artist, title PERO NO LOS ESPECIFICAMOS usamos ??
 * Ejemplo 4
 */

/*
$sentencia3 = $dbh->prepare("INSERT INTO prueba (nombre) VALUES (?)");
$sentencia3->bindParam(1, $nombre);

// insertar una fila
$nombre = 'Andreu';
$sentencia3->execute();
*/

/*
 * Obtener datos empleando sentencias preparadas
 * Pasamos el nombre por queryString
 * index.php?artist=David
 */

$sentencia = $dbh->prepare("SELECT * FROM album where artist = ?");
if ($sentencia->execute(array($_GET['artist']))) {
    while ($fila = $sentencia->fetch()) {
        print_r($fila);
    }
}
?>