<?php

require("../common_db.php");


if ($_POST['method'] == "add")
{
  $endPoint = "http://del.icio.us/api/posts/add?";
  $parameters = array();
  $parameters[] = array('url', urlencode($_POST['url']));
  $parameters[] = array('extended', urlencode($_POST['extended']));
  $parameters[] = array('tags', urlencode($_POST['tags']));
  $parameters[] = array('description', urlencode($_POST['description']));
  $parameters[] = array('dt', date("Y-m-jTH:i:sZ"));
  $xml = callDelicious($endPoint, $parameters);  
}else
{
  $endPoint = "http://del.icio.us/api/tags/get?";
  $xml = callDelicious($endPoint, array());  
  $usedTags = array();
  foreach($xml as $tag)
  {
    $usedTags[] = $tag['tag'];
  }
  sort($usedTags);
  $usedTags = implode(" ", $usedTags);
  
  echo <<< htmlCodeBlock
  <form method="post">
  <input type="hidden" name="method" value="add">
  URL: <input type="text" name="url"><br>
  Extended: <input type="text" name="extended"><br>
  Descirption:<input type="text" name="description"><br>
  Tags:<input type="text" name="tags"><br>
  Previously Used Tags: $usedTags<br>
  <br>
  <input type="submit">
  </form>
htmlCodeBlock;
}

  
  
  
  /*
  foreach($xml as $post)
  {
    echo "Site: {$post['description']} at {$post['href']} has the following tag(s): {$post['tag']}\n";
  }
  */  
function callDelicious($endPoint, $parameters)
{
  foreach ($parameters AS $paramater)
  {
  	$endPoint .= $paramater[0] . "=" . $paramater[1] . "&";
  }
  //echo $endPoint;
  
  $key = md5($endPoint);
  $today = date("Y-m-j H:i:s", time() - 5 * 60);
  $query = "SELECT `key`, `xml` FROM 11_delicious_cache WHERE `key` = '$key' && `tstamp` > '$today' ORDER BY `tstamp` DESC LIMIT 1";
  $result = getAssoc($query, 0);
  
  if (isset($result['$xml']))
  {
    //echo "Cache copy is valid";
    $xml = simplexml_load_string($result['xml']); 
  }else 
  {
     $xml = baseCall($endPoint);
     if ($xml == null)
     {
       return null;
     }else if ($xml == "THROTTLE")
     {
       // Throttled, get best possible
         $query = "SELECT `key`, `xml` FROM 11_delicious_cache WHERE `key` = '$key' ORDER BY `tstamp` DESC LIMIT 1";
         $result = getAssoc($query, 0);
         if (isset($result['xml']))
         {
           $safeXML = mysql_real_escape_string($result['xml']);
           $insertQuery = "REPLACE INTO 11_delicious_cache (`key`, `xml`, `tstamp`) VALUES (MD5('$endPoint'), '$safeXML', null)";
           insertQuery($insertQuery);
           $xml = simplexml_load_string($result['xml']);
         }else 
         {
            //Wasn't able to locate any cached copy
            $xml = null; 
         }
         
     }else if (is_object($xml))
     {
       //echo "Couldn't Cache, but I got the goods from the server";
       $safeXML = mysql_real_escape_string($xml->asXML());
       $insertQuery = "REPLACE INTO 11_delicious_cache (`key`, `xml`, `tstamp`) VALUES (MD5('$endPoint'), '$safeXML', null)";
       insertQuery($insertQuery);
     }else 
     {
        $xml = null;
     }
  }
  return $xml;
}

function baseCall($endPoint)
{
 
  $authorization = base64_encode("username:password");
  
  $url_info = parse_url($endPoint);
  
  $host = $url_info['host'];
  $path = $url_info['path'] . "?" . $url_info['query'];  
  $data = ""; 

  $fp=fsockopen($host, 80);
  fputs($fp, "POST " . $path . " HTTP/1.1\r\n");
  fputs($fp, "Host: " . $host ."\r\n");
  fputs($fp, "Authorization: Basic $authorization\r\n");
  fputs($fp, "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain\r\n");
  fputs($fp, "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n");
  fputs($fp, "Connection: close\r\n");
  fputs($fp, "User-Agent: PReinheimer Test App v0.1\r\n");
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
  if (strpos($http_headers, "200 OK"))
  {
    $firstLine = strpos($http_content, "\n");
    $http_content = substr($http_content, $firstLine + 1);
    $lastLine = strrpos($http_content, ">");
    $http_content = substr($http_content, 0, $lastLine + 1);
    
    $xml = simplexml_load_string($http_content);
    //echo "<pre>$http_content</pre>";
    return $xml;
  }else if (strpos($http_headers, "503"))
  {
    return "THROTTLE";
  }else 
  {
    return NULL;
  }
}

?>