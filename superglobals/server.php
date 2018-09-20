<?php echo "El accept_language es: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."<br>"; ?>
<table border="1">
    <tr>
        <td colspan="2">Mostrar todas las variables</td>
    </tr>
    <tr>
        <td><h1>Clave</h1></td>
        <td><h1>Valor</h1></td>
    </tr>
<?php foreach($_SERVER as $key=>$value){ ?>
    <tr>
        <td><h4><?php echo($key); ?></h4></td>
        <td><h4><?php echo($value); ?></h4></td>
    </tr>
<?php } ?>
</table>

