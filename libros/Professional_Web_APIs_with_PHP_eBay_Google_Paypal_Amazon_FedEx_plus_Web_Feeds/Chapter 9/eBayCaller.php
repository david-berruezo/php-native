<?php
exit('FILL IN YOUR DEV TOKENS!');

$devID = '';
$appID = '';
$cert = '';

$token = '';
$endPoint = 'https://api.sandbox.ebay.com/wsapi';
$version = "405"; 


function calleBay($callName, $request, $returnRAW = FALSE)
{

  global $appID, $version, $endPoint;
  
  $requestURL = "$endPoint?callname=$callName&appid=$appID&version=$version&routing=default"; 
  
  $length = strlen($request);
  
  $headers = array();
  $headers[] = 'SOAPAction: ""';
  $headers[] = "Content-Type: text/xml";
  $headers[] = "Content-Length: $length";
  
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
  $newXML = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children('urn:ebay:apis:eBLBaseComponents');
  return $newXML;
  }
} 

function generateRequest($body)
{
	global $appID, $version, $endPoint, $devID, $appID, $cert, $token;
	$request = <<< XMLBLOCK
<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema"  
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
  <soapenv:Header> 
    <RequesterCredentials soapenv:mustUnderstand="0" xmlns="urn:ebay:apis:eBLBaseComponents"> 
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


function generateBody($callName, $attributes)
{
  $body =  "<soapenv:Body>\n";
  $body .= "<{$callName}Request xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  foreach ($attributes AS $key => $value)
  {
    $body .= "<ns1:$key xmlns:ns1=\"urn:ebay:apis:eBLBaseComponents\">$value</ns1:$key>\n";
  }
  $body .= "</{$callName}Request>\n";
  $body .= "</soapenv:Body>";
  return $body;
}

function advGenerateBody($callName, $attributes, $depth = 0)
{
  $body = "";
  $prefix = str_repeat("\t", $depth);
  if ($depth == 0)
  {
    $body .= "<soapenv:Body>\n";
    $body .= "<{$callName}Request xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";  
  }
  foreach ($attributes AS $key => $value)
  {
    if (is_array($value))
    {
      $body .= $prefix . "<ns1:$key xmlns:ns1=\"urn:ebay:apis:eBLBaseComponents\">\n";
      $body .= $prefix . advGenerateBody($callName, $value, ($depth + 1));
      $body .= $prefix . "</ns1:$key>\n";
    }else
    {
      $body .= $prefix . "<ns1:$key xmlns:ns1=\"urn:ebay:apis:eBLBaseComponents\">$value</ns1:$key>\n";
    }
  }
  if ($depth == 0)
  {
    $body .= "</{$callName}Request>\n";
    $body .= "</soapenv:Body>";
  }
  return $body;
}
?>