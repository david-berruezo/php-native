<?php

include("RESTRequestProxy.class.php");

$proxy = new RESTRequestProxy("http://example.com/", "companies");

print_r( $proxy->create( array("name" => "MyVBO", "website"=>"http://www.myvbo.com")) );

?>