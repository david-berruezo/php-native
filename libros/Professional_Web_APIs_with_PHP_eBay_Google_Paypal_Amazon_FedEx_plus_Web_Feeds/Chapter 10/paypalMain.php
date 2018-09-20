<?php

/*Example Usage 
	$parameters[] = array("TransactionID", "ebl:TransactionId", "8N604562NC480291D");
	
	$xml = makeAPICall("GetTransactionDetails", $parameters);
	echo "<pre>";
	print_r($xml);
	echo "</pre>";
	$soapBody = $xml->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body');
	$body = $soapBody[0]->GetTransactionDetailsResponse;
	$timestamp = $body->Timestamp;
	$payerEmail = $body->PaymentTransactionDetails->PayerInfo->Payer;
	$paymentStatus = $body->PaymentTransactionDetails->PaymentInfo->PaymentStatus;
*/



function transLookUp($transid)
{
  $username = "USERNAME";
  $password = "PASSWORD";
  
    
  $request = <<< End_Of_Quote
<SOAP-ENV:Envelope
  xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/1999/XMLSchema"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Header>
    <RequesterCredentials xmlns="urn:ebay:api:PayPalAPI"
      SOAP-ENV:mustUnderstand="1">
      <Credentials xmlns="urn:ebay:apis:eBLBaseComponents">
        <Username>$username</Username>
        <Password>$password</Password>
        <Subject/>
      </Credentials>
    </RequesterCredentials>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <GetTransactionDetailsReq xmlns="urn:ebay:api:PayPalAPI">
      <GetTransactionDetailsRequest 
        xsi:type="ns:GetTransactionDetailsRequestType">
        <Version xmlns="urn:ebay:apis:eBLBaseComponents" 
          xsi:type="xsd:string">1.0</Version>
        <TransactionID xsi:type="ebl:TransactionId">$transid</TransactionID>
      </GetTransactionDetailsRequest>
    </GetTransactionDetailsReq>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
End_Of_Quote;
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/2.0/");
  curl_setopt($ch, CURLOPT_SSLCERT, "./cert_key_pem-1.txt");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  
  ob_start();
  curl_exec($ch);
  $response = ob_get_clean();
   echo $response;
  if (curl_error($ch))
	{
	  file_put_contents("/tmp/curl_error_log.txt", curl_errno($ch) . ": " . curl_error($ch), "a+");
	  curl_close($ch);
	  return null;
	}else
	{
	  curl_close($ch);  
    $xml = simplexml_load_string($response);
    return $xml;
    echo $response;
	}
}


function refund($transid)
{
  $username = "USERNAME";
  $password = "PASSWORD";
    $request = <<< End_Of_Quote
<SOAP-ENV:Envelope
  xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/1999/XMLSchema"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Header>
    <RequesterCredentials xmlns="urn:ebay:api:PayPalAPI"
      SOAP-ENV:mustUnderstand="1">
      <Credentials xmlns="urn:ebay:apis:eBLBaseComponents">
        <Username>$username</Username>
        <Password>$password</Password>
        <Subject/>
      </Credentials>
    </RequesterCredentials>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <RefundTransactionReq xmlns="urn:ebay:api:PayPalAPI">
      <RefundTransactionRequest 
        xsi:type="ns:RefundTransactionRequestType">
        <Version xmlns="urn:ebay:apis:eBLBaseComponents" 
          xsi:type="xsd:string">1.0</Version>
        <TransactionID xsi:type="ebl:TransactionId">$transid</TransactionID>
        <RefundType>Full</RefundType>
      </RefundTransactionRequest>
    </RefundTransactionReq>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
End_Of_Quote;

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/2.0/");
  curl_setopt($ch, CURLOPT_SSLCERT, "./cert_key_pem-1.txt");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  
  ob_start();
  curl_exec($ch);
  $response = ob_get_clean();
   echo $response;
  if (curl_error($ch))
	{
	  file_put_contents("/tmp/curl_error_log.txt", curl_errno($ch) . ": " . curl_error($ch), "a+");
	  curl_close($ch);
	  return null;
	}else
	{
	  curl_close($ch);  
    $xml = simplexml_load_string($response);
    return $xml;
    echo $response;
	}
}
function makeAPICall($specificAPIName, $APIparameters)
{
$username = "USERNAME";
$password = "PASSWORD";
$paramaterList = "";
foreach ($APIparameters as $paramater)
{
  $paramaterList .= "<{$paramater[0]} xsi:type=\"{$paramater[1]}\">{$paramater[2]}</{$paramater[0]}>\n";
}
  
$request = <<< End_Of_Quote
<SOAP-ENV:Envelope
  xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/1999/XMLSchema"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Header>
    <RequesterCredentials xmlns="urn:ebay:api:PayPalAPI"
      SOAP-ENV:mustUnderstand="1">
      <Credentials xmlns="urn:ebay:apis:eBLBaseComponents">
        <Username>$username</Username>
        <Password>$password</Password>
        <Subject/>
      </Credentials>
    </RequesterCredentials>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <{$specificAPIName}Req xmlns="urn:ebay:api:PayPalAPI">
      <{$specificAPIName}Request xsi:type="ns:{$specificAPIName}RequestType">
        <Version xmlns="urn:ebay:apis:eBLBaseComponents" 
          xsi:type="xsd:string">1.0</Version>
        $paramaterList
      </{$specificAPIName}Request>
    </{$specificAPIName}Req>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
End_Of_Quote;


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/2.0/");
  curl_setopt($ch, CURLOPT_SSLCERT, "./cert_key_pem-1.txt");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  
  ob_start();
  curl_exec($ch);
  $response = ob_get_clean();
  
  if (curl_error($ch))
	{
	  file_put_contents("/tmp/curl_error_log.txt", curl_errno($ch) . ": " . curl_error($ch), "a+");
	  curl_close($ch);
	  echo "curl error logged";
	  return null;
	}else
	{
	  curl_close($ch);  
	  $response2 = str_replace("><", ">\n<", $response);
	  //echo $response2;
    //echo "<br><hr><br>";
    $xml = simplexml_load_string($response);
    return $xml;
	}
}

function searchEmail($email, $date = "2000-01-29T12:00:01.00Z")
{
  $parameters = array();
  $parameters[] = array("StartDate", "ebl:dateTime", $date);
  $parameters[] = array("Payer", "ebl:string", "$email");
  $xml = makeAPICall("TransactionSearch", $parameters);
  return $xml;
}

function massPay($emails, $subject, $amount)
{
  
  $username = "USERNAME";
  $password = "PASSWORD";
  $parameters = array();
  $parameters[] = array("EmailSubject", "ebl:string", "Weekly Paycheck");
  $parameters[] = array("Payer", "ebl:string", "$email");
  
  $specificAPIName = "MassPay";
  
  foreach($emails as $email)
  { 
      $parameterList .= "<MassPayItem xsi:type=\"ebl:MassPayItemType\">\n";
      $parameterList .= "\t<ReceiverEmail xsi:type=\"ebl:string\">$email</ReceiverEmail>\n";
      $parameterList .= "\t<Amount currencyID=\"USD\" xsi:type=\"ebl:string\">$amount</Amount>\n";
      $parameterList .= "\t<Note xsi:type=\"ebl:string\">Thanks</Note>\n";
      $parameterList .= "</MassPayItem>\n";
  }
  
  $request = <<< End_Of_Quote
<SOAP-ENV:Envelope
  xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/1999/XMLSchema"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Header>
    <RequesterCredentials xmlns="urn:ebay:api:PayPalAPI"
      SOAP-ENV:mustUnderstand="1">
      <Credentials xmlns="urn:ebay:apis:eBLBaseComponents">
        <Username>$username</Username>
        <Password>$password</Password>
        <Subject/>
      </Credentials>
    </RequesterCredentials>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <{$specificAPIName}Req xmlns="urn:ebay:api:PayPalAPI">
      <{$specificAPIName}Request xsi:type="ns:{$specificAPIName}RequestType">
        <Version xmlns="urn:ebay:apis:eBLBaseComponents" 
          xsi:type="xsd:string">1.0</Version>
        $parameterList
      </{$specificAPIName}Request>
    </{$specificAPIName}Req>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
End_Of_Quote;

echo $request;
echo "<hr>";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/2.0/");
  curl_setopt($ch, CURLOPT_SSLCERT, "./cert_key_pem-1.txt");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  
  ob_start();
  curl_exec($ch);
  $response = ob_get_clean();
  
  if (curl_error($ch))
	{
	  file_put_contents("/tmp/curl_error_log.txt", curl_errno($ch) . ": " . curl_error($ch), "a+");
	  curl_close($ch);
	  echo "curl error logged";
	  return null;
	}else
	{
	  curl_close($ch);  
	  $response2 = str_replace("><", ">\n<", $response);
	  echo $response2;
    //echo "<br><hr><br>";
    $xml = simplexml_load_string($response);
    return $xml;
	}
  
  
}



function massPay2($emails, $subject, $amount)
{
  $parameters = array();
  $parameters[] = array("EmailSubject", "ebl:string", "$subject");
  foreach($emails as $email)
  { 
    $parameterList = "\t<ReceiverEmail xsi:type=\"ebl:string\">$email</ReceiverEmail>\n";
    $parameterList .= "\t<Amount currencyID=\"USD\" xsi:type=\"ebl:string\">$amount</Amount>\n";
    $parameterList .= "\t<Note xsi:type=\"ebl:string\">Thanks</Note>\n";
    $parameters[] = array("MassPayItem", "ebl:MassPayItemType", "$parameterList");
  }
  $xml = makeAPICall("MassPay", $parameters);
  return $xml;
}
?>