<?php
$serviceOptions = array();
$serviceOptions['PRIORITYOVERNIGHT'] = "Priority Overnight";
$serviceOptions['STANDARDOVERNIGHT'] = "Standard Overnight";
$serviceOptions['FIRSTOVERNIGHT'] = "First Overnight";
$serviceOptions['FEDEX2DAY'] = "Two Day";
$serviceOptions['FEDEXEXPRESSSAVER'] = "Express Saver";
$serviceOptions['INTERNATIONALPRIORITY'] = "International Priority";
$serviceOptions['INTERNATIONALECONOMY'] = "International Economy";
$serviceOptions['INTERNATIONALFIRST'] = "International First";
$serviceOptions['FEDEX1DAYFREIGHT'] = "One Day Freight";
$serviceOptions['FEDEX2DAYFREIGHT'] = "Two Day Freight";
$serviceOptions['FEDEX3DAYFREIGHT'] = "Three Day Freight";
$serviceOptions['FEDEXGROUND'] = "Ground";
$serviceOptions['GROUNDHOMEDELIVERY'] = "Ground Home Delivery";
$serviceOptions['INTERNATIONALPRIORITY FREIGHT'] = "International Priority 
  Freight";
$serviceOptions['INTERNATIONALECONOMY FREIGHT'] = "International Economy Freight";
$serviceOptions['EUROPEFIRSTINTERNATIONALPRIORITY'] = "Europe First International 
  Priority";

$request = <<< XMLREQUEST
<?xml version="1.0" encoding="UTF-8" ?>
  <FDXRateAvailableServicesRequest xmlns:api="http://www.fedex.com/fsmapi" 
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
  xsi:noNamespaceSchemaLocation="FDXRateRequest.xsd">
  <RequestHeader>
    <CustomerTransactionIdentifier>1</CustomerTransactionIdentifier>
    <AccountNumber>$accountNumber</AccountNumber>
    <MeterNumber>$meterNumber</MeterNumber>
    <CarrierCode>$carrier</CarrierCode>
  </RequestHeader>
  <ShipDate>2006-04-17</ShipDate>
  <DropoffType>REGULARPICKUP</DropoffType>
  <Packaging>FEDEXBOX</Packaging>
  <WeightUnits>LBS</WeightUnits>
  <Weight>10.0</Weight>
  <ListRate>1</ListRate>
  <OriginAddress>
    <StateOrProvinceCode>DC</StateOrProvinceCode>
    <PostalCode>20500</PostalCode>
    <CountryCode>US</CountryCode>
  </OriginAddress>
  <DestinationAddress>
    <StateOrProvinceCode>DC</StateOrProvinceCode>
    <PostalCode>20310-6605</PostalCode>
    <CountryCode>US</CountryCode>
  </DestinationAddress>
  <Payment>
    <PayorType>SENDER</PayorType>
  </Payment>
  <PackageCount>1</PackageCount>
</FDXRateAvailableServicesRequest>
XMLREQUEST;

echo "<h3>Request</h3>\n";
echo "<pre>\n";
print_r(simplexml_load_string($request));
echo "</pre>\n";
echo "<h3>Response</h3>\n";
$response = callFedEx($request);
foreach ($response->Entry AS $service)
{
  echo "It would cost \${$service->EstimatedCharges->DiscountedCharges->NetCharge} 
    to mail the package with " . $serviceOptions["{$service->Service}"] . ' ';
  echo "Which has an estimated delivery date of " . date('l dS \of F', 
    strtotime($service->DeliveryDate)) . "<br>";
}
echo "<pre>";
print_r($response);
echo "</pre>";


?>