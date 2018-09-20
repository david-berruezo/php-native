<?php
function callAPIQuick($endpoint, $devkey, $action, $type, $keyword)
{
  $action = urlencode($action);
  $type = urlencode($type);
  $keyword = urlencode($keyword);
  $url = $endpoint . "?devkey=$devkey&action=$action&type=$type&keyword=$keyword";
  $response = @file_get_contents($url);
  return $response;
}
?>