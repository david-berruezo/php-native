<?php
$endPoint = "http://www.flickr.com/services/rest/?";

$paramaters = array();
$paramaters[] = array("method", "flickr.people.findByUsername");
$paramaters[] = array("api_key", "KEY");
$paramaters[] = array("username", "YOURUSERNAME");

foreach ($paramaters AS $paramater)
{
	$endPoint .= $paramater[0] . "=" . $paramater[1] . "&";
}

$response = file_get_contents($endPoint);
$xml = simplexml_load_string($response);
echo $response;
$nsid = $xml->user['nsid'];
?>
