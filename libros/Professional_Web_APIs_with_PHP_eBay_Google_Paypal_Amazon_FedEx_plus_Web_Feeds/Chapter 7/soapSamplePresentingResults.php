<?php

require('../lib/nusoap.php');

$client = 
new soapclient("http://soap.amazon.com/schemas2/AmazonWebServices.wsdl", true);

$params = array(
		    'keyword'    => 'elements of style',
		    'page'        => 1,
		    'mode'        => 'books',
		    'tag'         => 'preinheimerco-20',
		    'type'        => 'heavy',
		    'devtag'      => '1PHH5VTRY7D300H7JTR2'
);

$namespace = 'http://soap.amazon.com';
$action = 'http://soap.amazon.com';
$method = "KeywordSearchRequest";
$result = $client->call($method, 
  array('KeywordSearchRequest' => $params), 
  $namespace, $action);

//print_r($result);
$resultItems = $result['Details'];

foreach ($resultItems AS $item)
{
  $title = $item['ProductName'];
  $url = $item['Url'];
  $image = $item['ImageUrlSmall'];
  $catagories = $item['BrowseList'];
  $summary = $item['BrowseList'];
  $authorList = implode($item['Authors'], ", ");
  $price = $item['ListPrice'];
  echo "<img src=\"$image\" align=\"left\">";
  echo "<a href=\"$url\" title=\"Learn More at Amazon.com\">$title<a><br>";
  echo "Author(s): " . $authorList . "<br>";
  echo "List Price: " . $price; 
  echo "<hr>";
}
?>