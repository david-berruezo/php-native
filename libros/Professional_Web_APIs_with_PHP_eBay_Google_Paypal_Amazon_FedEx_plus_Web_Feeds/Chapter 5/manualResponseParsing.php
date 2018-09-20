<?php
$response = callAPIQuick('http://library.example.com/api.php', '123', 'search', 'book', 'style');
if ($response)
{
  $xml = simplexml_load_string($response); 
  print_r($xml);
}else
{
  echo "Error loading feed"; 
}
?>