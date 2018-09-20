<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 18:10
 */
$cursor = "cr_123456";

try {
    $usuario    = "root";
    $contraseña = "Berruezin23";
    $dbh = new PDO('mysql:host=localhost;dbname=davidber_web', $usuario, $contraseña,array(PDO::ATTR_PERSISTENT => true));
    /*
    var_dump($mbd);
    echo("<br>");
    foreach($mbd->query('SELECT * from album') as $fila) {
        print_r($fila);
    }
    $mbd = null;
    */
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try{
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->beginTransaction();
    $dbh->exec("insert into album (id, artist, title) values (1, 'Artista', 'Artista Album')");
    $dbh->exec("insert into prueba (id, nombre) values (1, 'Artista')");
    $dbh->commit();
} catch (PDOException $e){
    $dbh->rollBack();
    echo "Fallo: " . $e->getMessage();
}

/*
$dbh->beginTransaction();
$query = "SELECT yourFunction(0::smallint,'2013-08-01 00:00','2013-09-01 00:00',1::smallint,'$cursor')";
$dbh->query($query);
$query = "FETCH ALL IN \"$cursor\"";
echo "begin data<p>";
foreach ($dbh->query($query) as $row)
{
    echo "$row[0] $row[1] $row[2] <br>";
}
echo "end data";
*/
?>
