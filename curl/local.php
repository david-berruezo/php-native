<?php
$header[] = "Accept: */*";
$header[] = "Cache-Control: max-age=0";
$header[] = "Accept-Charset: utf-8;q=0.7,*;q=0.7";
$header[] = "Accept-Language: en-us,en;q=0.5";
$header[] = "Pragma: ";
// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://localhost:8800/php/php/curl/detalle.html");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSLVERSION,3);
//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$result = curl_exec ( $ch );
$err = curl_errno ( $ch );
$errmsg = curl_error ( $ch );
$header = curl_getinfo ( $ch );
$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
print_r($result);
echo '------------------------';
print_r($ch);
print_r($err);
print_r($errmsg);
print_r($header);
print_r($httpCode);

if( ! $result = curl_exec($ch))
{
    trigger_error(curl_error($ch));
}else{
    echo $result;
}
// grab URL and pass it to the browser
// curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
?>