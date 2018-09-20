<?php

include("CompanySoap.class.php");

$server = new SoapServer('company.wsdl');

$server->setClass("CompanySOAP");
$server->handle();

?>