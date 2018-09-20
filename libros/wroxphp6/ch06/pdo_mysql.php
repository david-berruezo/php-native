<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/07/2016
 * Time: 11:17
 */
$dsn        = 'mysql:dbname=davidber_web;host=127.0.0.1';
$user       = 'davidber_usuario';
$password   = 'Berruezin23';
$strDSN     = "mysql:dbname=davidber_web;host=localhost;port=3306;user=davidber_usuario;password=Berruezin23";
$variable   = " \"Hola\" ";
echo($variable."<br>");
$objPdo     = "";
try {
    $objPdo = new PDO('mysql:host=localhost;dbname=davidber_web;charset=utf8', 'davidber_usuario', 'Berruezin23',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    consultarTabla();
    //$dbh = new PDO($strDSN);
    //$dbh = new PDO($dsn, $user, $password);
    print "Successfully connected ....\n";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


/*
 * Consultamos tabla normal
 */
function consultarTabla(){
    global $objPdo;
    $i              = 0;
    $strQuery       = "SELECT * FROM empresas";
    $objStatement   = $objPdo->query($strQuery);
    var_dump($objStatement);
    foreach ($objStatement as $arRow) {
        print "--------------- Row -----------------<br/>\n";
        //print_r($arRow);
        foreach ($arRow as $key => $value) {
            // Si sacamos el is numeric php pdo crea un indice numerico para la salida de cada registro
            if (!is_numeric($key)){
                print "Column: $key, value: $value <br/> \n";
            };
            $i++;
        };
        print "--------------- Row -----------------<br/>\n";
    }
}



function otraConsulta(){
    global $objPdo;
    // Let ’ s interrogate the database
    $i = 0;
    $strQuery     = "SELECT * FROM empresas";
    $objStatement = $objPdo->prepare($strQuery);
    $objStatement->execute();
    while ($arRow = $objStatement->fetch(PDO::FETCH_ASSOC)) {
        print "------ Row $i ------ <br/>\n" ;
        foreach  ($arRow as $key => $value) {
                    print "Column: $key, value $value <br/ > \n " ;
        };
        $i++;
        print "------ row ------ <br/>\n" ;
    };
}


/*
# id, foto, foto_grande, nombre
'1', 'fcvsicono.jpg', 'fcvs.jpg', 'Fcvs'
'2', 'saytelicono.jpg', 'saytel.jpg', 'Saytel'
'3', 'aristaicono.jpg', 'arista.jpg', 'Arista'
'4', 'iniciativesarnoicono.jpg', 'iniciativesarno.jpg', 'Inciatives Arno S.L'
'5', 'ecommerceicono.jpg', 'ecommerce.jpg', 'eCommerce Barcelona 360'
'6', 'dynamicono.jpg', 'dynam.jpg', 'Dynam-Iq'

object(PDOStatement)#2 (1) { ["queryString"]=> string(22) "SELECT * FROM empresas" }
    Column id,value1 < br / > Column foto,valuefcvsicono.jpg < br / > Column foto_grande,valuefcvs.jpg < br / > Column nombre,valueFcvs < br / > Row 8
    Column id,value2 < br / > Column foto,valuesaytelicono.jpg < br / > Column foto_grande,valuesaytel.jpg < br / > Column nombre,valueSaytel < br / > Row 16
    Column id,value3 < br / > Column foto,valuearistaicono.jpg < br / > Column foto_grande,valuearista.jpg < br / > Column nombre,valueArista < br / > Row 24
    Column id,value4 < br / > Column foto,valueiniciativesarnoicono.jpg < br / > Column foto_grande,valueiniciativesarno.jpg < br / > Column nombre,valueInciatives Arno S.L < br / > Row 32
    Column id,value5 < br / > Column foto,valueecommerceicono.jpg < br / > Column foto_grande,valueecommerce.jpg < br / > Column nombre,valueeCommerce Barcelona 360 < br / > Row 40
    Column id,value6 < br / > Column foto,valuedynamicono.jpg < br / > Column foto_grande,valuedynam.jpg < br / > Column nombre,valueDynam-Iq < br / > Successfully connected ....
*/

$ch = curl_init("http://www.example.com/");
$fp = fopen("example_homepage.txt", "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
?>