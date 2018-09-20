<?php

$request = <<< XMLREQUEST
<?xml version="1.0" encoding="UTF-8" ?>
  <FDXShipRequest xmlns:api="http://www.fedex.com/fsmapi"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="FDXShipRequest.xsd">
  <RequestHeader>
    <CustomerTransactionIdentifier>1</CustomerTransactionIdentifier>
    <AccountNumber>$accountNumber</AccountNumber>
    <MeterNumber>$meterNumber</MeterNumber>
    <CarrierCode>$carrier</CarrierCode>
  </RequestHeader>
  <DropoffType>REGULARPICKUP</DropoffType>
  <Service>PRIORITYOVERNIGHT</Service>
  <Packaging>FEDEXBOX</Packaging>
  <WeightUnits>LBS</WeightUnits>
  <Weight>4.0</Weight>
  <Origin>
    <Contact>
      <PersonName>Paul Reinheimer</PersonName>
      <CompanyName>Wrox</CompanyName>
      <PhoneNumber>5191234567</PhoneNumber>
      <E-MailAddress>paul@preinheimer.com</E-MailAddress>
    </Contact>
    <Address>
      <Line1>564 Elm Street</Line1>
      <Line2>Little Nook under the stairs</Line2>
      <City>NowhereVille</City>
      <StateOrProvinceCode>TN</StateOrProvinceCode>
      <PostalCode>38017</PostalCode>
      <CountryCode>US</CountryCode>
    </Address>
  </Origin>
  <Destination>
    <Contact>
      <PersonName>Chris Shiflett</PersonName>
      <CompanyName>Wrox</CompanyName>
      <PhoneNumber>6121234567</PhoneNumber>
      <E-MailAddress>chriss@preinheimer.com</E-MailAddress>
    </Contact>
    <Address>
      <Line1>37 East 14th St</Line1>
      <Line2>Suite 204</Line2>
      <City>New York</City>
      <StateOrProvinceCode>NY</StateOrProvinceCode>
      <PostalCode>10011</PostalCode>
      <CountryCode>US</CountryCode>
    </Address>
  </Destination>
  <SpecialServices>
    <EMailNotification>
      <Shipper>
        <ShipAlert>1</ShipAlert>
        <DeliveryNotification>1</DeliveryNotification>
        <LanguageCode>EN</LanguageCode>
      </Shipper>
      <Recipient>
        <ShipAlert>1</ShipAlert>
        <DeliveryNotification>1</DeliveryNotification>
        <LanguageCode>EN</LanguageCode>
      </Recipient>
    </EMailNotification>
  </SpecialServices>
  <Payment>
    <PayorType>SENDER</PayorType>
  </Payment>
  <ReferenceInfo>
    <CustomerReference>Order 6541325</CustomerReference>
  </ReferenceInfo>
  <Label>
    <Type>2DCOMMON</Type>
    <ImageType>PNG</ImageType>
  </Label>
</FDXShipRequest>
XMLREQUEST;

echo "<h3>Request</h3>\n";
echo "<pre>\n";
print_r(simplexml_load_string($request));
echo "</pre>\n";
echo "<h3>Response</h3>\n";
$response = callFedEx($request);
echo "Shipment Confirmed, your tracking number is: " . 
    $response->Tracking->TrackingNumber;
echo "<pre>";
print_r($response);
$label = base64_decode($response->Labels->OutboundLabel);
file_put_contents("/str/label/{$response->Tracking->TrackingNumber}.png", $label);
echo "</pre>";

?>