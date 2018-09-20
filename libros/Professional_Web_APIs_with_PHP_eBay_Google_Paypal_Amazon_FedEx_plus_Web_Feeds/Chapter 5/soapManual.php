<?php
function createRequest($devkey, $action, $type, $keyword)
{
  $request = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>
<SOAP-ENV:Envelope 
  xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" 
  xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" 
  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
  <SOAP-ENV:Body>
    <devkey xsi:type=\"xsd:int\">$devkey</devkey>
    <action xsi:type=\"xsd:string\">$action</action>
    <type xsi:type=\"xsd:string\">$type</type>
    <keyword xsi:type=\"xsd:string\">$keyword</keyword>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>";
  return $request;
}

function callSOAPAPI($data)
{
  $url = "http://library.example.com/api/soap/search";
  $url_info = parse_url($url);
  $host = $url_info['host'];
  $path = $url_info['path'];
  $fp=fsockopen($host, 80);
  fputs($fp, "GET " . $path . " HTTP/1.1\r\n");
  fputs($fp, "Host: " . $host ."\r\n");
  fputs($fp, "Accept: */*\r\n");
  fputs($fp, "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n");
  fputs($fp, "Connection: close\r\n");
  fputs($fp, "Content-Type: application/soap+xml\r\n");
  fputs($fp, "Content-Length: " . strlen($data) . "\r\n\r\n");
  fputs($fp, "$data");
  $response="";
  while(!feof($fp))
  {
    $response.=fgets($fp, 128);
  }
  fclose($fp);
  list($http_headers, $http_content)=explode("\r\n\r\n", $response);
  return $http_content;
}

$request = createRequest('123', 'search', 'book','style');
$response = callSOAPAPI($request);
