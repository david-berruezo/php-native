<?php
// Take search list
// Iterate through it
//  Repeat search incrementing start value untill domain is found
//  Record placement, time
//  Compare placement to yesterdays
//  If worse, generate note
//  If Better, generate note
// Send notes if present
// Exit
require("../common_db.php");
require('../lib/nusoap.php');
//Load Search List
$query = "SELECT * FROM 06_google_monitor";
$searchTerms = getAssoc($query);
$client = new soapclient("http://example.preinheimer.com/google/googleapi/GoogleSearch.wsdl", true);
$desiredURL = "http://www.filedonkey.com";
$length = strlen($desiredURL);
$message = "";
foreach($searchTerms as $term)
{
  //echo "WOrking on term";
  $placement = 1;
  $searchQuery = $term['query'];
  $allowance = $term['allowance']; 
  $start = 0;
  $found = 0;
  while ($found == 0 && $start < 50)
  {
    $result = runGoogleSearch(&$client, $searchQuery, $start);
    echo "I sit at found=$found, start=$start, query=$searchQuery";
    $queryResults = $result['resultElements'];
    foreach($queryResults as $item)
    {
      if(substr($item['URL'], 0, $length) == $desiredURL)
      {
        //record placement
        $query = "INSERT INTO 06_google_monitor_results (`query`, `placement`, `timestamp`) 
        VALUES ('$searchQuery', '$placement', null)";
        
     //   echo $query;
        insertQuery($query);
        $found = 1;
        break;
      }else
      {
        echo "No Match, $desiredURL isn't present in " . $item['URL'] . "<br>";
      }
      $placement++;
    }
    $start = $start + 10;
  }
  if ($found == 0)
  {
     $query = "INSERT INTO 06_google_monitor_results (`query`, `placement`, `timestamp`) 
        VALUES ('$searchQuery', '" . $placement * 10 . "', null)";
  }
  $message .= checkResults($searchQuery, $allowance);
  
}


function checkResults($searchQuery, $allowance)
{
  $query = "SELECT placement FROM 06_google_monitor_results 
  WHERE `query` = '$searchQuery' ORDER BY timestamp DESC LIMIT 2"; 
  echo $query . "<br>";
  $recentResults = getAssoc($query, 2);
  $thisRun = $recentResults[0]['placement'];
  $lastRun = $recentResults[1]['placement'];
  if ($thisRun == $lastRun)
  {
    return ""; 
  }else if (($thisRun - $lastRun) > $allowance)
  {
    echo "WARNING ranking for $searchQuery has dropped from $lastRun to $thisRun<br>\n";
    return "WARNING ranking for $searchQuery has dropped from $lastRun to $thisRun\n";
  }else if (($lastRun - $thisRun) > $allowance)
  {
    echo "Good News! Ranking for $searchQuery has increased from $lastRun to $thisRun<br>\n";
    return "Good News! Ranking for $searchQuery has increased from $lastRun to $thisRun\n";
  }else
  {
    return ""; 
  }
}




function runGoogleSearch($client, $searchQuery, $start)
{
  echo "called";
   $query = array(
  	'key'=>'u6U/r39QFHK18Qcjz/XdWSbptVaj9k1t',
  	'q'=>$searchQuery,
  	'start'=>$start,
  	'maxResults'=>10,
  	'filter'=>true,
  	'restrict'=>'',
  	'safeSearch'=>true,
  	'lr'=>'',
  	'ie'=>'',
  	'oe'=>''
  );
  
  $result = $client->call("doGoogleSearch", $query, "urn:GoogleSearch", "urn:GoogleSearch");
  return $result;
}


?>