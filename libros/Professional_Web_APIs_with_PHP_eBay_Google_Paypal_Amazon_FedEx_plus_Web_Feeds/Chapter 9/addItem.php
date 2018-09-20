<?php
exit('FILL IN YOUR DEV TOKENS!');

$devID = '';
$appID = '';
$cert = '';

$token = '';
$endPoint = 'https://api.sandbox.ebay.com/wsapi';
$version = "405"; 


 $request = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
  <request>
  	<DetailLevel><![CDATA[1]]></DetailLevel>
  	<SiteId><![CDATA[0]]></SiteId>
  	<Verb><![CDATA[AddItem]]></Verb>
  	<ErrorLevel><![CDATA[1]]></ErrorLevel>
  	<RequestToken><![CDATA[$token]]></RequestToken>
  	
    <Country>US</Country> 
    <Category>14111</Category>
    <Currency>1</Currency> 
    <Description>This is the item description.</Description> 
    <ListingDuration>Days_7</ListingDuration> 
    <Location>San Jose, CA</Location> 
    <PaymentMethods>PaymentSeeDescription</PaymentMethods> 
    <PrimaryCategory>
      <CategoryID>357</CategoryID> 
    </PrimaryCategory>
    <Quantity>1</Quantity> 
    <RegionID>0</RegionID> 
    <ReservePrice>5.0</ReservePrice> 
    <StartPrice>1.0</StartPrice> 
    <Title>Test Auction, TESTBAIT23</Title>
    <VisaMaster>1</VisaMaster>
    <SellerPays>0</SellerPays>
    <Version>2</Version>
    <Duration><![CDATA[5]]></Duration>
    <MinimumBid>1.00</MinimumBid>
  </request>";

  // header("Content-Type: application/xml");
  //$response = sendRequest($request, 1, "AddItem");
  //echo $response;
  $itemInfo = array();
  addItem($itemInfo);
  
  
function addItem($itemInfo)
{
  global $token;
  
  $itemInfo[] = array("DetailLevel" => "1"); 
  $itemInfo[] = array("SiteId" => "0"); 
  $itemInfo[] = array("Verb" => "AddItem"); 
  $itemInfo[] = array("ErrorLevel" => "1"); 
  $itemInfo[] = array("RequestToken" => $token); 
  
  $request = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
  $request .= "<request>\n";
  foreach ($itemInfo as $key => $value)
  {
    $request .= "\t<{$key}>{$value}</{$key}>\n"; 
  }
  $request .= "</request>";
}


function sendRequest($request, $detailLevel, $callName)
{
  global $devID, $appID, $cert, $token, $endPoint;
  
  $requestLength = strlen($request);
  
  $headers = array();
  $headers[] = "X-EBAY-API-COMPATIBILITY-LEVEL: 353";
  $headers[] = "X-EBAY-API-SESSION-CERTIFICATE: $devID;$appID$cert";
  $headers[] = "X-EBAY-API-DEV-NAME: $devID";
  $headers[] = "X-EBAY-API-APP-NAME: $appID";
  $headers[] = "X-EBAY-API-CERT-NAME: $cert";
  $headers[] = "X-EBAY-API-CALL-NAME: $callName";
  $headers[] = "X-EBAY-API-SITEID: 0";
  $headers[] = "X-EBAY-API-DETAIL-LEVEL: $detailLevel";
  $headers[] = "Content-Type: text/xml";
  $headers[] = "Content-Length: $requestLength";
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $endPoint);
  curl_setopt($ch, CURLOPT_HEADER, false);          // Don't bother giving us the header back
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);   // Send our header
  curl_setopt($ch, CURLOPT_POST, true);             // Send a POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);   // This is the post to send
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   // Return the result, rather than printing it out
  $data = curl_exec($ch);
  curl_close($ch);
  return $data; 
}

?>