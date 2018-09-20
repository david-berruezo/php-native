<?php


require('../lib/nusoap.php');

$today = date("Y-m-j");

$client =
new soapclient("http://weather.gov/forecasts/xml/DWMLgen/wsdl/ndfdXML.wsdl", true);

$params = array(
'latitude'    => "40.7409",
'longitude'   => "-73.9997",
'startDate'   => $today,
'numDays'     => '2',
'format'      => '24 hourly'
);

$result = $client->call('NDFDgenByDay',$params);
$error = $client->getError();
if ($error)
{
  echo "error<pre>";
  print_r($error);
  print_r($result);
  echo "</pre>";
  exit;
}

$xml = simplexml_load_string($result);

$dayNames = array();
$weatherDates = array();
foreach($xml->data->{'time-layout'}->{'start-valid-time'} AS $time)
{
  $weatherDates[] = (string) $time;
  $dayNames[] = date("l", strtotime($time));
}

$maxTemperature = array();
foreach($xml->data->parameters->temperature[0]->value AS $maxTemp)
{
  $maxTemperature[] = (int) $maxTemp;
}

$minTemperature = array();
foreach($xml->data->parameters->temperature[1]->value AS $minTemp)
{
  $minTemperature[] = (int) $minTemp;
}

$icons = array();
foreach($xml->data->parameters->{'conditions-icon'}->{'icon-link'} as $icon)
{
  $icons[] = (string) $icon;
}
echo "<table>\n<tr>";
$day = 0;
while(isset($weatherDates[$day]))
{
  echo "<th colspan=\"2\">{$dayNames[$day]}</th>";
  $day++;
}
echo "</tr>";

echo "<tr>";
$day = 0;
while(isset($weatherDates[$day]))
{
  echo "<td><b>Low</b>: {$minTemperature[$day]} <br>";
  echo "<b>High</b>:{$maxTemperature[$day]}<br></td>";
  echo "<td><img src=\"{$icons[$day]}\" align=\"right\">\n\n<br></td>";
  $day++;
}
echo "</tr></table>";

?>