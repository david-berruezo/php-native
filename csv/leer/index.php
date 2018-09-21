<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>preba</title>
</head>
<body>
<table border="1">
<?php
$fila = 1;
if (($gestor = fopen("products_import0.csv", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
        $numero = count($datos);
        echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
        $fila++;
        ?>
        <tr>
        <?php
        for ($c=0; $c < $numero; $c++) { ?>
            <td><?php echo $datos[$c] . "<br />\n"; ?></td>
        <?php
        }
        ?>
        </tr>
    <?php
    }
    fclose($gestor);
}
?>
</table>
