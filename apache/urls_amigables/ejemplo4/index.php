<?php
// comentarios
/**
 * Le pasamos esta url
 * http://localhost/php/php/apache/urls_amigables/ejemplo4/user/david
 * http://localhost/php/php/apache/urls_amigables/ejemplo4/usuario/11-david
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articulos</title>
</head>
<body>
<h1>Estas en el index</h1>
<h4>Eres el user: <?php (isset($_GET['user']) ? $user = $_GET['user'] :  $user = "" );?><?php echo $user; ?></h4>
<h4>Eres el usuario: <?php (isset($_GET['usuario']) ? $usuario = $_GET['usuario'] :  $usuario = "" );?><?php echo $usuario; ?></h4>
<h4>Eres el usuarito: <?php (isset($_GET['usuarito']) ? $usuarito = $_GET['usuarito'] :  $usuarito = "" );?><?php echo $usuarito; ?></h4>
</body>
</html>
