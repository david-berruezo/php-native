<?php
// comentarios
/**
 * Le pasamos esta url
 * http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina1/parametro1/parametro2
 * http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina2/parametro1/parametro2
 * http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina3/parametro1/parametro2
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba ejemplo3</title>
    <!-- Jquery && Proper -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="./node_modules/bootstrap/dist/js/bootstrap.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</head>
<body>
<a href="http://localhost/php/php/apache/urls_amigables/ejemplo3/index.php">Inicio</a>
<a href="http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina1/parametro1/parametro2">Pagina 1</a>
<a href="http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina2/parametro1/parametro2">Pagina 2</a>
<a href="http://localhost/php/php/apache/urls_amigables/ejemplo3/pagina3/parametro1/parametro2">Pagina 3</a>
<h1>Bienvenido a la pagina dei inicio</h1>
<?php
if (isset($_GET["view"])){
    $url = explode("/", $_GET["view"]);
    print_r($url);
    echo "<h4>La pagina es:".$url[0]."</h4>";
    echo "<h4>El parametro 1 es:".$url[1]."</h4>";
    echo "<h4>El parametro 2 es:".$url[2]."</h4>";
}
?>
</body>
</html>
