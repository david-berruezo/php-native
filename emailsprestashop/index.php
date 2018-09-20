<?php
$mysqli = new mysqli('localhost', 'ted_web_live', 'eqsbobzufwplxamjydji', 'ted_web_live');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
//echo 'Success... ' . $mysqli->host_info . "\n";
if ($result = $mysqli->query("select * from ps_orders where current_state<>11 or current_state<>12 or current_state<>15 or current_state <> 16 or current_state <> 13", MYSQLI_USE_RESULT)) {
    $vectorClientes = array();
    $vectorFechas   = array();
    $vectorEmails   = array();
    while ($row = $result->fetch_assoc()){
        $fechaCreacion   = date('Y-m-d', strtotime($row["date_add"]));
        $anoActual       = date("Y");
        $fechaSuperior   = date('Y-m-d', strtotime($anoActual."/09/01"));
        if ($fechaCreacion > $fechaSuperior){
            array_push($vectorClientes,$row["id_customer"]);
        }
        //$user_arr[] = $row;
    }
    foreach($vectorClientes as $cliente){
        if ($result2 = $mysqli->query("select * from ps_customer where id_customer=".$cliente, MYSQLI_USE_RESULT)) {
            while ($row2 = $result2->fetch_assoc()){
                array_push($vectorEmails,$row2["email"]);
            }
        }

    }
    $duplicadosEmails = array_unique($vectorEmails);
    $output = fopen('email.csv', 'w');
    foreach ($duplicadosEmails as $campo) {
        echo $campo."<br>";
        fputcsv($output, $campo,';');
    }
    fclose($output);
}
$mysqli->close();
?>

