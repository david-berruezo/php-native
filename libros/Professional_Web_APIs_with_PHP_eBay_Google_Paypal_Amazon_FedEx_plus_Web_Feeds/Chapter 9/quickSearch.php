<html>
<head>
<title>eBay Quick Search REST API</title>
</head>
<body>
<form method="get">
  Search Terms: <input type="text" name="search"><br>
  <input type="submit">
</form>
<pre>
<?php

$endPoint = "http://rest.api.sandbox.ebay.com/restapi";
$requestToken   = "oVAr7OhSbdw%3D**%2Bs1d4ta8quAac9G3rvTuhs8IPvg%3D";
$requestUserId  = "wroxuser";
$resultsPerPage = 10;
if (isset($_GET['search']))
{
   if (isset($_GET['page']) && ctype_digit($_GET['page']))
   {
      $page =  $_GET['page'];
   }else 
   {
      $page = 0; 
   }
   $skip = $page * $resultsPerPage;
   $searchTerms = urlencode($_GET['search']);
   $fullEndPoint = $endPoint . "?RequestToken={$requestToken}&RequestUserId={$requestUserId}&Query={$searchTerms}&CallName=GetSearchResults&MaxResults=$resultsPerPage&Skip={$skip}";
   $results =  file_get_contents($fullEndPoint);
   $xml = simplexml_load_string($results);
   
   echo "Your search for <b>$searchTerms</b> yeilded a total of <b>{$xml->Search->GrandTotal}</b> results<br>";
   echo "These are results <b>" . ($page * $resultsPerPage + 1) . "</b> to <b>" . ((1 + $page) * $resultsPerPage) . "</b><br><br>";
   foreach($xml->Search->Items->Item AS $item)
   {
      
    $link = $item->Link;
    $link = str_replace("http://cgi.ebay.com/", "http://cgi.sandbox.ebay.com/", $link);
    echo "<a href=\"$link\">{$item->Title}</a><br>";
    echo "Current Price: <b>{$item->LocalizedCurrentPrice}</b> \t Bids: <b>{$item->BidCount}</b><br>";
    if ($item->ItemProperties->BuyItNow == 1)
    {
      echo "Buy it Now Price: <b>{$item->BINPrice}</b><br>";
    }
    echo "Auction Start: <b>{$item->StartTime}</b> \t Auction End: <b>{$item->EndTime}</b><br>";
    $endTime = strtotime($item->EndTime);
    $timeRemaining = $endTime - time();
    //$timeRemaining = date(" " , $timeRemaining);
    
    echo "Time Remaining: <b>$timeRemaining</b><br>";
    echo "Time Remaining: <b>" . prettyTimeRemaining($timeRemaining) ."</b><br>";
    echo "<br><br>";
   }
   
   
   if (trim($xml->Search->HasMoreItems) == 1)
   {
      echo "<a href=\"?search={$searchTerms}&page=" . ($page + 1) . "\">Next Page</a><br>";
   }
   
}


function prettyTimeRemaining($timestamp)
{
  $timeRemaining = "";
  $weeks = floor($timestamp / 604800);
  $timestamp = $timestamp -  ($weeks * 604800);
  if ($weeks > 0)
  {
    $timeRemaining .= "$weeks Week(s) "; 
  }
  $days = floor($timestamp / 86400);
  $timestamp = $timestamp - ($days * 86400);
  if ($days > 0)
  {
    $timeRemaining .= "$days Day(s) "; 
  }
  
  $hours = floor($timestamp / 3600);
  $timestamp = $timestamp - ($hours * 3600);
  if ($hours > 0)
  {
    $timeRemaining .= "$hours Hour(s) "; 
  }
  
  $minutes = floor($timestamp / 60);
  $timestamp = $timestamp - ($minutes * 60);
  if ($minutes > 0)
  {
    $timeRemaining .= "$minutes Minute(s) "; 
  }
  
  $seconds = $timestamp;
  $teimRemaining .= "$seconds Second(s)";
  
  return $timeRemaining;
  
}

?>
</pre>
</body>
</html>