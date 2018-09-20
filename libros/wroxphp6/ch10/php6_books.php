<?php
$client = new SoapClient("http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl");
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
  print '<a href="' . $item->DetailPageURL . '">' . $item->ItemAttributes->Title . "</a><br>\n";
}
?>