<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.example.com/companies/myvbo.json");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$data = json_decode(curl_exec($ch));
curl_close($ch);

?>
