<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 10/07/2016
 * Time: 16:39
 */

/*
 * Conexion a base de datos
 */
$mysqlhost   = "localhost";
$mysqluser   = "root";
$mysqlpasswd = "Berruezin23";
$mysqldbname = "davidber_web";

$link =
    @mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if ($link == FALSE) {
    echo "Unfortunately, a connection to the  database cannot be made.\n";
    exit();
}
mysql_select_db($mysqldbname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Title</title>
</head>
<body>
</body>
</html>
