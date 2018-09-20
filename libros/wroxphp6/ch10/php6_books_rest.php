<?php
//Base URL for all AWS REST operations
define('AWS_BASE_URL','http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService');
//AWS Access Key ID 
define('AWS_ACCESS_KEY_ID', '[Your AWS Key]');
$params = array();
$params['Operation'] = 'ItemSearch';
$params['SearchIndex'] = 'Books';
$params['Keywords'] = 'PHP 6';
//Construct the URL
$url = AWS_BASE_URL . '&AWSAccessKeyId=' . AWS_ACCESS_KEY_ID;
foreach($params as $name => $value) {
  //Need to URL encode in case there are spaces or other funny chars 
  //in the values
  //$value = urlencode(unicode_encode($value, 'ISO-8859-1'));
  $value = urlencode($value);
  $url .= "&$name=$value";
}
$hc = curl_init($url);
curl_setopt($hc, CURLOPT_RETURNTRANSFER, 1);
$xml = curl_exec($hc);

$out = new SimpleXMLElement($xml);

foreach($out->Items->Item as $item) {
  print '<a href="' . $item->DetailPageURL . '">' . 
        $item->ItemAttributes->Title . "</a><br>\n";
}
?>


