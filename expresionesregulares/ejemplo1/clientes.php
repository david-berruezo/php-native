<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 07/07/2016
 * Time: 17:22
 */
if ($_GET["id"]){
    $cliente = $_GET["id"];
    echo("El cliente es: ". $cliente ."<br>");
}else{
    echo("Bienvenido al Ejemplo1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
<h1>Ahora estás en clientes.php</h1>
<a href="clientes/juan">Juan</a>
</body>
</html>

