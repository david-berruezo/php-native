<?php
/**
 * Pruebas solarium
 */
include_once ("vendor/autoload.php");
/*
$config = array(
    "endpoint" => array("localhost" => array("host"=>"127.0.0.1",
        "port"=>"8983", "path"=>"/solr", "core"=>"collection1",)
    ) );

$client = new Solarium\Client($config);
$ping = $client->createPing();
$result = $client->ping($ping);
$result->getStatus();
*/
$versión_solr = solr_get_version();
print $versión_solr;
?>