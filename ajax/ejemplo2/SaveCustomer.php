<?php
/*
 * Recogemos las variables
 * via Post
 */
header("Content-Type: text/plain");
//get information
$sName    = $_POST["txtName"];
$sAddress = $_POST["txtAddress"];
$sCity    = $_POST["txtCity"];
$sState   = $_POST["txtState"];
$sZipCode = $_POST["txtZipCode"];
$sPhone   = $_POST["txtPhone"];
$sEmail   = $_POST["txtEmail"];
//status message
$sStatus  = "";

/*
 * Conectamos a la bd
 */
try {
    $usuario    = "root";
    $contraseña = "Berruezin23";
    $mbd        = new PDO('mysql:host=localhost;dbname=ajaxlibro', $usuario, $contraseña);
    $mbd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

/*
 * Creamos el pdo prepare
 * e insertamos datos de las
 * variables que nos han pasado
 * por el formulario
 */
$sentencia = $mbd->prepare("INSERT INTO customers (Name,Address,City,State,Zip,Phone,Email) VALUES (:name, :address, :city, :state, :zip, :phone,:email)");
$sentencia->bindParam(':name', $sName);
$sentencia->bindParam(':address', $sAddress);
$sentencia->bindParam(':city', $sCity);
$sentencia->bindParam(':state', $sState);
$sentencia->bindParam(':zip', $sZipCode);
$sentencia->bindParam(':phone', $sPhone);
$sentencia->bindParam(':email', $sEmail);

// insertar una fila
$sentencia->execute();

?>

