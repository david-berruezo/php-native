<?php
function generateBody($callName, $attributes)
{
  $body = "<soapenv:Body>\n";
  $body .= "<{$callName}Request xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  foreach ($attributes AS $key => $value)
  {
    $body .= "<ns1:$key xmlns:ns1=\"urn:ebay:apis:eBLBaseComponents\">
      $value</ns1:$key>\n";
  }
  $body .= "</{$callName}Request>\n";
  $body .= "</soapenv:Body>";
  return $body;
}

function generateRequest($body)
{
	global $version, $endPoint, $devID, $appID, $cert, $token;
	$request = <<< XMLBLOCK
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
  $body 
</soapenv:Envelope>  
XMLBLOCK;
	return $request;
}


function newGetTime()
{
	$call = "GeteBayOfficialTime";
	$queryInfo = array();
	$queryInfo["Version"] = 425;
	$myRequest = generateBody($call, $queryInfo);
	$message = generateRequest($myRequest);
	$xml =  calleBay($call, $message, FALSE);
	echo "Time: " . $xml->GeteBayOfficialTimeResponse->Timestamp . "\n";
}
?>