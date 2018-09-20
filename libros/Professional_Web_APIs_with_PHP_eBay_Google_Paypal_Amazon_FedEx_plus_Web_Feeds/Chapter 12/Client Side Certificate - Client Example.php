<?php
function callAPI($endpoint, $requestBody)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $endpoint);
  curl_setopt($ch, CURLOPT_SSLCERT, "../certs/cert_key_pem-1.txt");
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
  ob_start();
  curl_exec($ch);
  $response = ob_get_clean();
  if (curl_error($ch))
	{
	  file_put_contents("/tmp/curl_error_log.txt", curl_errno($ch) . ": " . 
    curl_error($ch), "a+");
	  curl_close($ch);
	  return null;
	}else
	{
	   curl_close($ch);  
    return $response;
	}
} 
?>