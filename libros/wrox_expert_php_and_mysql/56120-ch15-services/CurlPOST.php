<?php

$postData = array(
  "name" => "MyVBO",
  "website" => "http://www.myvbo.com/"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.example.com/companies/myvbo.json");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = json_decode(curl_exec($ch));
curl_close($ch);

?>