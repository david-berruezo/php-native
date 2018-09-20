<html lang="es">
<head>
    <title>MI PRIMERA PÁGINA EN PHP	</title>
    <meta charset="UTF-8">
</head>
<body>

<?php
$a=56;$b=66;
function escribir(){
    $a=func_get_arg(0);
    $b=func_get_arg(1);
    $c=func_get_arg(2);
    //global $b;
    $d=$GLOBALS['b'];
    echo nl2br("a=$a \n b=$d<br> a+b= ".($a+$d));
    echo "<br>Me gusta $c";
    echo '<br>Me gusta $c';
}
escribir($a,"","Pamplona");
?>
</body>
</html>