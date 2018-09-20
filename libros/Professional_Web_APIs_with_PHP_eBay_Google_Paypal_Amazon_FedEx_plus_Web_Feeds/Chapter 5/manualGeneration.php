<?php
function callAPI($endpoint, $devkey, $action, $type, $keyword)
{
  $action = urlencode($action);
  $type = urlencode($type);
  $keyword = urlencode($keyword);
  $url = $endpoint . "?devkey=$devkey&action=$action&type=$type&keyword=$keyword";
  $url_info = parse_url($url);
  $host = $url_info['host'];
  $path = $url_info['path'] . "?" . $url_info['query'];
  $data = "";
  $fp=fsockopen($host, 80);
  fputs($fp, "POST " . $path . " HTTP/1.1\r\n");
  fputs($fp, "Host: " . $host ."\r\n");
  fputs($fp, "Accept: */*\r\n");
  fputs($fp, "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n");
  fputs($fp, "Connection: close\r\n");
  fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-Length: " . strlen($data) . "\r\n\r\n");
  fputs($fp, "$data");
  $response="";
  while(!feof($fp))
  {
    $response.=fgets($fp, 128);
  }
  fclose($fp);
  list($http_headers, $http_content)=explode("\r\n\r\n", $response);
  return $http_content;
}
?>