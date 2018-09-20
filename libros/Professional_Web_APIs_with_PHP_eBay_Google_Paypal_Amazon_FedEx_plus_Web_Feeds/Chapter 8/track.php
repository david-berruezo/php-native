<?php

$request = <<< XMLREQUEST
<?xml version="1.0" encoding="UTF-8" ?>
  <FDXTrackRequest xmlns:api="http://www.fedex.com/fsmapi" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:noNamespaceSchemaLocation="FDXShipRequest.xsd">
  <RequestHeader>
    <AccountNumber>$accountNumber</AccountNumber>
    <MeterNumber>$meterNumber</MeterNumber>
    <CarrierCode>$carrier</CarrierCode>
  </RequestHeader>
  <PackageIdentifier>
    <Value>470034028693</Value>
    <Type>TRACKING_NUMBER_OR_DOORTAG</Type>
  </PackageIdentifier>
  <DestinationCountryCode>US</DestinationCountryCode>
  <DetailScans>1</DetailScans>
</FDXTrackRequest>
XMLREQUEST;

echo "<h3>Request</h3>\n";
echo "<pre>\n";
print_r(simplexml_load_string($request));
echo "</pre>\n";
echo "<h3>Response</h3>\n";
$response = callFedEx($request);
if (!isset($response->TrackProfile->SoftError))
{
  foreach ($response->TrackProfile->Scan AS $scanPoint)
  {
    echo "{$scanPoint->Date},{$scanPoint->Time} - {$scanPoint->ScanDescription} in 
      {$scanPoint->City}, {$scanPoint->StateOrProvinceCode}<br>";
  }
}else 
{
  echo "Tracking information not yet available";
}
echo "<pre>";
print_r($response);
echo "</pre>";



?>