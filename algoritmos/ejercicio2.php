<html>
<?php
if(isset($_POST['imin']) && isset($_POST['imax'])){
    $imin=$_POST['imin'];
    $imax=$_POST['imax'];
}else{
    $imin=0;
    $imax=10;
}
?>
<head>
    <title>
        EJERCICIO BUCLES PHP
    </title>
    <link rel="stylesheet" type="text/css" href="./css/estilo1.css" />
</head>
<body>
<center>
    <form action="./ejercicio2.php" method="POST">
        <table><tr><thcolspan=2>Crea las tabla entre valores</th></tr>
            <tr><td>Valor min</td><td><input name="imin" value="<?php echo $imin;?>" /></td></tr>
            <tr><td>Valor max</td><td><input name="imax" value="<?php echo $imax;?>" /></td></tr>
            <tr><td><input type="Reset" value="Borrar" /></td><td><input type="submit" value="Ver" /></td></tr>
        </table>
    </form>
    <?php
    $i=0;
    $j=0;
    echo "<div>";
    for($i=$imin;$i<($imax+1);$i++){
        echo "<table><tr><th colspan=2>Tabla del $i</th></tr>";
        for($j=1;$j<11;$j++){
            echo "<tr><td>$j x $i = </td><td>".($j*$i)."</td></tr>";
        }
        echo "</table>";
    }
    echo "</div>";
    ?>
</center>
</body>
</html>