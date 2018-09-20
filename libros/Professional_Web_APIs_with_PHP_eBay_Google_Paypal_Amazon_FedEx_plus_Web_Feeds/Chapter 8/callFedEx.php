<?php
function callFedEx($request)
{
  global $endpoint;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $endpoint);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $response = curl_exec($ch);
  if (curl_error($ch))
  {
    echo "<br>\n";
    echo "Errors were encountered:";
    echo curl_errno($ch);
    echo curl_error($ch);
    curl_close($ch);
    return NULL;
  }else
  {
    curl_close($ch);
    $xml = simplexml_load_string($response);
    return $xml;
  }
}

$endpoint = '';
echo "<pre>";
echo htmlentities($request);
echo "</pre>";
$response = callFedEx($request);
echo "Your meter number is: {$response->MeterNumber}, write that down\n";
echo "<pre>";
print_r($response);
echo "</pre>";

?>