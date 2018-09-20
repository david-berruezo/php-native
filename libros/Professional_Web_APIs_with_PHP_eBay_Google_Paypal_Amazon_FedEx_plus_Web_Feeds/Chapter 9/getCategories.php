<?php
function getCategories($parent = -1)
{
  $call = "GetCategories";
  $attributes = array();
  $attributes['Version'] = 425;
  $attributes['CategorySiteID'] = 0;
  
  if ($parent != -1)
  {
    $attributes['CategoryParent'] = $parent;
  }else 
  {
    $attributes['LevelLimit'] = 1;  
  }

  $myRequest = generateBody($call, $attributes);
  $message = generateRequest($myRequest);
  $breifXML = simplexml_load_string(calleBay($call, $message, TRUE));
  $lastUpdated = $parent . "." . $breifXML->
    children('http://schemas.xmlsoap.org/soap/envelope/')->
    children('urn:ebay:apis:eBLBaseComponents')->GetCategoriesResponse->
    UpdateTime . ".xml";

  if (file_exists("/eBayCatCache/$lastUpdated"))
  { 
    echo "<!-- CACHE -->\n";
    $xml = simplexml_load_file("/tmp/$lastUpdated");

  }else
  {
    echo "<!-- NEW -->\n";
    $attributes['DetailLevel'] = 'ReturnAll';
    $myRequest = generateBody($call, $attributes);
    $message = generateRequest($myRequest);
    $xml = calleBay($call, $message, TRUE); 
    file_put_contents("/tmp/$lastUpdated", $xml);
    $xml = simplexml_load_string($xml);
  }

  $xml = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents');
  return $xml;
}
?>