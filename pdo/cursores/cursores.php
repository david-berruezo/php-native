<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 17:56
 */

# Incluimos la conexión a la bd
require_once("../conexionnormal/conexionnormal.php");

#Ejemplos

#Ejemplo 1 Obtención de filas usando diferentes tipos de obtención

$gsent = $mbd->prepare("SELECT * from album");
$gsent->execute();

/* Prueba de tipos de PDOStatement::fetch */
print("PDO::FETCH_ASSOC: ");
print("Devolver la siguiente fila como un array indexado por nombre de colunmna\n");
$result = $gsent->fetch(PDO::FETCH_ASSOC);
print_r($result);
print("\n");

print("PDO::FETCH_BOTH: ");
print("Devolver la siguiente fila como un array indexado por nombre y número de columna\n");
$result = $gsent->fetch(PDO::FETCH_BOTH);
print_r($result);
print("\n");

print("PDO::FETCH_LAZY: ");
print("Devolver la siguiente fila como un objeto anónimo con nombres de columna como propiedades\n");
$result = $gsent->fetch(PDO::FETCH_LAZY);
print_r($result);
print("\n");

print("PDO::FETCH_OBJ: ");
print("Devolver la siguiente fila como un objeto anónimo con nombres de columna como propiedades\n");
$result = $gsent->fetch(PDO::FETCH_OBJ);
print $result->NAME;
print("\n");


$mbd = null;
