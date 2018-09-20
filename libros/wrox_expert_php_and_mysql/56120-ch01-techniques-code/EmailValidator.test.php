<?php

include_once("EmailValidator.class.php");

$email = "security@php.net";
$lazy = true; // Set to true to fully validate
              // Requires the ISP to allow outbound connection to port 25

$validator = new EmailValidator($email);

echo $email." ".( $validator->isValid( $lazy ) ? "is valid" : "is not valid" )."\n";

?>
