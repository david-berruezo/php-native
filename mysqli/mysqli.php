<?php
/**
 * Mysqli.
 * User: root
 * Date: 16/11/16
 * Time: 14:51
 */

// Creamos una conexión
$conexion = new mysqli('localhost', 'root', 'Berruezin23', 'prueba_prestashop');

if ($conexion->connect_error) {
    die('Connect Error (' . $conexion->connect_errno . ') '. $conexion->connect_error);
}
echo 'Success... ' . $conexion->host_info . "\n";
/* Create table doesn't return a resultset */
/*
if ($result = $conexion->query("select * from ps_productlikes", MYSQLI_USE_RESULT)) {
    while ($row = $result->fetch_assoc()){
        //var_dump($row);
        echo "Contador : ".$row["count"]."<br>";
        if ($row["count"] <= 100 ){
            var_dump($row);
            $aleatorio = rand(150 ,550);
            $row["count"] = $aleatorio;
            var_dump($row);
        }
        //$user_arr[] = $row;
    }
}
*/
$conexion->close();
?>
