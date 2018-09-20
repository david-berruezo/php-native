<?php

$server = new SoapServer('company.wsdl');

$companyConnection = mysql_connect("localhost", "username", "password");
mysql_select_db("companies", $companyConnection);

function GetCompany( $id ) {
  global $companyConnection;

  $res = mysql_query("SELECT * FROM `companies` WHERE `id`=".(int)$id,
                     $companyConnection);

  if ( $row = mysql_fetch_assoc($res) ) {
    $company = new Company();
    $company->name = $row["name"];
    $company->website = $row["website"];

    return array( $id, $company );

  } else {
    throw new SoapFault("Server","Company not found.");
  }
}

/*
  For a completed and object oriented version see CompanySoap.class.php
*/

$server->addFunction("GetCompany");
$server->handle();

?>