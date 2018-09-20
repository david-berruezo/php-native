<?php
/*
$vector = array("david","dolores","antonio");
var_dump($vector);
echo($vector);
*/


try {
    $usuario    = "root";
    $contraseña = "Berruezin23";
    $mbd        = new PDO('mysql:host=localhost;dbname=davidber_web', $usuario, $contraseña);
    $mbd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    probar();
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

function probar(){
    global $mbd;
    var_dump($mbd);
    echo("<br>");
    foreach($mbd->query('SELECT * from categoria') as $fila) {
        print_r($fila);
    }
    $mbd = null;
}

?>