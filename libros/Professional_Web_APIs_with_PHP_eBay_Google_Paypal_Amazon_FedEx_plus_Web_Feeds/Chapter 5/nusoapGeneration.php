<?php
require('../lib/nusoap.php');
$client = new soapclient("http://library.example.com/api/soap/wsdl/", true);
$params = array(
  'devkey'   => '123',
  'action'   => 'search',
  'type'     => 'book',
  'keyword'  => 'style'
);
$namespace = 'http://library.example.com';
$action = 'http://library.example.com/api/soap/search';
$method = "SearchRequest";
$result = $client->call($method, 
  array('SearchRequest' => $params), 
  $namespace, $action);

?>