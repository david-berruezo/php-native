<?php

require('../lib/nusoap.php');

$client = 
new soapclient("http://soap.amazon.com/schemas2/AmazonWebServices.wsdl", true);

$params = array(
		    'keyword'    => 'chris shiflett',
		    'page'        => 1,
		    'mode'        => 'books',
		    'tag'         => 'preinheimerco-20',
		    'type'        => 'lite',
		    'devtag'      => '1PHH5VTRY7D300H7JTR2'
);


$namespace = 'http://soap.amazon.com';
$action = 'http://soap.amazon.com';
$method = "KeywordSearchRequest";
$result = $client->call($method, 
  array('KeywordSearchRequest' => $params), 
  $namespace, $action);

//print_r($result);
$resultItems = $result['items'];

foreach ($resultItems AS $item)
{
  echo $item['ProductName'];
}
?>