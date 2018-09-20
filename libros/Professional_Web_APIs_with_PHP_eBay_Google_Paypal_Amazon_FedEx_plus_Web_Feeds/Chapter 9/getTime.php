<?php
function calleBay($callName, $request, $returnRAW = FALSE)
{
  global $appID, $version, $endPoint;
  $requestURL = "$endPoint?callname=$callName&appid=$appID
    &version=$version&routing=default"; 
  $length = strlen($request);
  $headers = array();
  $headers[] = 'SOAPAction: ""';
  $headers[] = "Content-Type: text/xml";
  $headers[] = "Content-Length: $length";
As mentioned earlier several of the request parameters will be passed in the get line, the endpoint for the request is generated, including the name request being made, and some specifics about the application making the request. 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $requestURL);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $data = curl_exec($ch);
  curl_close($ch);
  if ($returnRAW == TRUE)
  {
    return $data;
  }else
  {
    $xml = simplexml_load_string($data);                                          
    $newXML = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->
      children('urn:ebay:apis:eBLBaseComponents');
    return $newXML;
  }
}


function getSimpleTime()
{
  global $version, $devID, $appID, $cert, $token;
  $call = "GeteBayOfficialTime";
  $message = <<< XMLBLOCK
<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"  
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
  <soapenv:Header> 
    <RequesterCredentials soapenv:mustUnderstand="0" 
         xmlns="urn:ebay:apis:eBLBaseComponents"> 
       <eBayAuthToken>$token</eBayAuthToken> 
       <ns:Credentials xmlns:ns="urn:ebay:apis:eBLBaseComponents"> 
        <ns:DevId>$devID</ns:DevId> 
        <ns:AppId>$appID</ns:AppId> 
        <ns:AuthCert>$cert</ns:AuthCert> 
       </ns:Credentials> 
    </RequesterCredentials> 
  </soapenv:Header> 
  <soapenv:Body> 
  <GeteBayOfficialTimeRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
  <ns1:Version xmlns:ns1="urn:ebay:apis:eBLBaseComponents">$version</ns1:Version> 
  </GeteBayOfficialTimeRequest> 
  </soapenv:Body> 
</soapenv:Envelope>
XMLBLOCK;
  $RAWxml = calleBay($call, $message, TRUE);  
  $xml = simplexml_load_string($RAWxml);
  
  print_r($xml);
  echo "Time: " . $xml->children('http://schemas.xmlsoap.org/soap/envelope/')
    ->children('urn:ebay:apis:eBLBaseComponents')->GeteBayOfficialTimeResponse
    ->Timestamp . "\n";
}
?>