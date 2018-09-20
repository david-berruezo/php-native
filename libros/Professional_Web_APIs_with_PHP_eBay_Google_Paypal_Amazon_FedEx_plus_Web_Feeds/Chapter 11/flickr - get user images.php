<?php
$paramaters = array();
$endPoint = "http://www.flickr.com/services/rest/?";
$paramaters[] = array("method", "flickr.photos.search");
$paramaters[] = array("api_key", "KEY");
$paramaters[] = array("user_id", "USERID");

foreach ($paramaters AS $paramater)
{
	$endPoint .= $paramater[0] . "=" . $paramater[1] . "&";
}
$response = file_get_contents($endPoint);
$xml = simplexml_load_string($response);

foreach($xml->photos->photo as $photo)
{
 echo "<img src=\"http://static.flickr.com/{$photo['server']}/{$photo['id']}_
  {$photo['secret']}_m.jpg\" style=\"float: left; display: table-cell; width:   
  240px; height: 240px; text-align: center; vertical-align: middle;\">\n";
}

?>
