<?php
/*
* Case of use of Csv.class
* @package csv
* @date 2005-08-01
*/
require("_preload.php");
try {
    $datos = array();
    $datos
    for ($i=0;$i<2;$i++){
        $datos[$i]["Nombre"]    = "David";
        $datos[$i]["Apellido"]  = "Berruezo";
        $datos[$i]["Fecha"]     = "23/11/1978";
    }
    $Csv     = new Csv($filename = "test.csv", $separator = ";");
    $csvData = $Csv->readAll();
    $csvData = $Csv->write($datos,false);
    /*
    echo "<table border='1'>";
    foreach($csvData as $row) {
        echo "<tr>";
        foreach($row as $col) {
            echo "<td>$col</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    */
}
catch (Exception $e) {
    echo "<hr />";
    echo "Exception code:  <font style='color:blue'>". $e->getCode() ."</font>";
    echo "<br />";
    echo "Exception message: <font style='color:blue'>". nl2br($e->getMessage()) ."</font>";
    echo "<br />";
    echo "Thrown by: '". $e->getFile() ."'";
    echo "<br />";
    echo "on line: '". $e->getLine() ."'.";
    echo "<br />";
    echo "<br />";
    echo "Stack trace:";
    echo "<br />";
    echo nl2br($e->getTraceAsString());
    echo "<hr />";
}
?>