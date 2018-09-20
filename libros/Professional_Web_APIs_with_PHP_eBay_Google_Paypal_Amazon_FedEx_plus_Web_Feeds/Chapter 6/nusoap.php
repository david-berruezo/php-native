<?php

require('../lib/nusoap.php');
//$client = new soapclient("http://api.google.com/search/beta2", false);
$client = new soapclient("http://example.preinheimer.com/google/googleapi/GoogleSearch.wsdl", true);

$client->soap_defencoding = 'UTF-8';

$query = array(
	'key'=>'u6U/r39QFHK18Qcjz/XdWSbptVaj9k1t',
	'q'=>'paul reinheimer',
	'start'=>0,
	'maxResults'=>2,
	'filter'=>true,
	'restrict'=>'',
	'safeSearch'=>true,
	'lr'=>'',
	'ie'=>'',
	'oe'=>''
);

$result = $client->call("doGoogleSearch", $query, "urn:GoogleSearch", "urn:GoogleSearch");

echo "<b>Search Query</b>: <i>" . $result['searchQuery'] . "</i><br>";
$x = $result['startIndex'];
$y = $result['endIndex'];

if ($result['estimateIsExact'])
{
  echo "Displaying results $x to $y, out of " . $result['estimatedTotalResultsCount'] . " results<br>";
}else
{
  echo "Displaying results $x to $y, out of an estimated " . $result['estimatedTotalResultsCount'] . " results<br>";
}
$queryResults = $result['resultElements'];
foreach($queryResults as $item)
{
  echo "<a href=\"{$item['URL']}\">{$item['title']}</a><br>";
  echo $item['snippet'] . "<br><br>";
}


?>
