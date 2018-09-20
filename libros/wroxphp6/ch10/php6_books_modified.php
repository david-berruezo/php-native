<?php
$client = new SoapClient("http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl", array('trace' => 1));
$request = array(
                 'SearchIndex' => 'Books',
                 'Keywords' => 'PHP 6'
                );
$params = array(
                'AWSAccessKeyId' => '[your Amazon AWS Access Key]',
                'Operation' => 'ItemSearch',
                'Request' => $request
                );

$out = $client->ItemSearch($params);
foreach($out->Items->Item as $item) {
  print '<a href="' . $item->DetailPageURL . '">' . $item->ItemAttributes->Title . 
        "</a><br>\n";
}
print "<pre>" . htmlentities(print_r($client->__getLastRequest(), true)) ."</pre>\n";
print "<pre>" . htmlentities(print_r($client->__getLastResponse(), true)) . "</pre>\n";
?>
