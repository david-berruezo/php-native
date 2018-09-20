<?php
/**
 * David Berruezo.
 * User: David
 * Date: 13/07/2016
 * Time: 12:15
 */
?>
<?php
header("Content-Type: text/plain");

/*
 * Creamos las sentencias
 * sql create table
 * e insert
 *
 */
$create = <<<EOT
    CREATE TABLE Customers(
    CustomerId 	 int(11) NOT NULL auto_increment PRIMARY KEY,
	Name 		 varchar(255) NOT NULL default "",
	Address 	 varchar(255) NOT NULL default "",
	City 		 varchar(255) NOT NULL default "",
	State 		 varchar(255) NOT NULL default "",
	Zip 		 varchar(255) NOT NULL default "",
	Phone 	     varchar(255) NOT NULL default "",
	Email 		 varchar(255) NOT NULL default ""
) ENGINE = INNODB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT="Customer Data";
EOT;

$insert = <<<EOT
    INSERT INTO `Customers` VALUES (1, 'Michael Smith', '123 Somewhere Road', 'Beverly Hills', 'California', '90210', '(555) 555-1234', 'michael@somewhere.com');
    INSERT INTO `Customers` VALUES (2, 'Matthew Johnson', '1234 Somewhere Else Street', 'Elsewhere', 'Confusion', '00000', '(555) 555-2345', 'johnboy@neato.net');
    INSERT INTO `Customers` VALUES (3, 'Cindy Benjamin', '1313 Mockingbird Lane', 'Somewhere', 'Montana', '00000', '(555) 555-9876', 'cindybean@mcok.net');
    INSERT INTO `Customers` VALUES (4, 'Mary Klein', '10 Highland Avenue', 'Salem', 'Massachusetts', '01970', '(555) 555-4920', 'mary@klein.net');
EOT;


/*
 * Recogemos variables por get
 * y cremos otra variable
 */
if (isset($_GET["id"]))
    $sID   = $_GET["id"];
$sInfo = "";

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
 * Hacemos una transacción de la
 * la creación de la tabla y los inserts
 * a la tabla
 */
if (isset($_GET["estado"]) && _GET["estado"] == "inicial"){
    try{
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();
        $mbd->exec($create);
        $mbd->exec($insert);
        $mbd->commit();
    } catch (PDOException $e){
        $mbd->rollBack();
        echo "Fallo: " . $e->getMessage();
    }
}

/*
function probar(){
    global $mbd;
    var_dump($mbd);
    echo("<br>");
    foreach($mbd->query('SELECT * from album') as $fila) {
        print_r($fila);
    }
    $mbd = null;
}
*/


//create the SQL query string
//$sQuery = "Select * from Customers where CustomerId=".$sID;

// $res = $db->query('SELECT * FROM `mytable` WHERE true', PDO::FETCH_ASSOC);
// $db->query("Select * from table where id=".$mysecuredata);


if($sInfo == '') {
    $sql = "SELECT * from album where CustomerId=$sID";
    foreach ($mbd->query($sql) as $fila) {
        print_r($fila);
    }
}

$mbd = null;


//make the database connection
/*
$oLink = mysql_connect($sDBServer,$sDBUsername,$sDBPassword);
@mysql_select_db($sDBName) or $sInfo = "Unable to open database";

if($sInfo == '') {
    if($oResult = mysql_query($sQuery) and mysql_num_rows($oResult) > 0) {
        $aValues = mysql_fetch_array($oResult,MYSQL_ASSOC);
        $sInfo   = $aValues['Name']."<br />".$aValues['Address']."<br />".
            $aValues['City']."<br />".$aValues['State']."<br />".
            $aValues['Zip']."<br /><br />Phone: ".$aValues['Phone']."<br />".
            "<a href=\"mailto:".$aValues['E-mail']."\">".$aValues['E-mail']."</a>";
    } else {
        $sInfo = "Customer with ID $sID doesn't exist.";
    }
}
mysql_close($oLink);
echo $sInfo;
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba jQuery</title>
    <script src="../../js/jquery-3.1.10.js"></script>
    <script src="js/funciones.js"></script>
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
</body>
</html>
