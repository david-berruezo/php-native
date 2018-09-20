<?php

include "bootstrap.php";

$options = array
(
    'hostname' => 'DAVID02',
    'login'    => 'admin',
    'password' => 'changeit',
    'port'     => '8983',
    'path'     => 'c:\solr-4.0.0',
    "core"=>"collection1",
);

$client = new SolrClient($options);

$doc = new SolrInputDocument();

$doc->addField('id', 334455);
$doc->addField('cat', 'Software');
$doc->addField('cat', 'Lucene');

$updateResponse = $client->addDocument($doc);

print_r($updateResponse->getResponse());

/* you will have to commit changes to be written if you didn't use $commitWithin */
$client->commit();
