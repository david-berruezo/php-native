<html>
<head>
<title>Simple Search Interface</title>
</head>
<body>
<form action="" method="get">
<input type="hidden" name="start" value="0">
<input type="text" name="query" value="">
<input type="submit">
</form>
<br>
<?php
require ("../common_db.php");

if (isset($_GET['query']))
{
  require('../lib/nusoap.php');
  $searchQuery = html_entity_decode($_GET['query']);

  $start = $_GET['start'];

  //$client = new soapclient("http://api.google.com/search/beta2", false);
  $client = new soapclient("http://example.preinheimer.com/google/googleapi/GoogleSearch.wsdl", true);
  if ($client->getError()) 
  {
	  echo "Error creating client <pre>" . $client->getError() . "</pre>";
	  exit;
  }
  $client->soap_defencoding = 'UTF-8';
  
  $result = getGoogleResults(&$client, $searchQuery, $start);
  $suggestions = getSuggested($searchQuery);
  
  
  if ($client->fault) 
  {
	  echo 'Client Fault<pre>'; 
	  print_r($result); 
	  echo '</pre>';
  } else {
	
  	if ($client->getError()) 
  	{
  		echo 'Error<pre>' . $client->getError() . '</pre>';
  	} else 
  	{
  		$searchQuery = htmlentities($searchQuery);
    	echo "<b>Search Query</b>: <i>" . $searchQuery . "</i><br>";
      $x = $result['startIndex'];
      $y = $result['endIndex'];
      
      if ($result['estimateIsExact'])
      {
        echo "Displaying results $x to $y, out of " . $result['estimatedTotalResultsCount'] . " results<br>";
      }else
      {
        echo "Displaying results $x to $y, out of an estimated " . $result['estimatedTotalResultsCount'] . " results<br>";
      }
      $queryResults = $result['resultElements'];
      if (count($queryResults) > 1)
      {
        foreach($queryResults as $item)
        {
          echo "<a href=\"{$item['URL']}\">{$item['title']}</a><br>\n";
          echo $item['snippet'] . "<br><br>\n";
        }
      }else
      {
        echo "No results to display";
      } 
      $nextStart = $result['endIndex'];
      echo "<br><br>";
      
      echo "<a href=\"./nusoap.simple.php?query={$searchQuery}&start=$nextStart\">Next 10 Results</a>";
    }
  }
}

function runGoogleSearch($client, $searchQuery, $start)
{
   $query = array(
  	'key'=>'u6U/r39QFHK18Qcjz/XdWSbptVaj9k1t',
  	'q'=>"site:preinheimer.com " . $searchQuery,
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

function getGoogleResults($client, $searchQuery, $start)
{
  $key = md5($start . $searchQuery);
  // Check for recent items
  $query = "SELECT * FROM 06_google_cache_meta WHERE `key` = '$key' AND ((NOW() - `time`) < 84600)";
  $results = getAssoc($query);
  
  //print_r($results);
  if (count($results) > 0)
  {
    //echo "Using Cached Data";
    //Cache exists and is recent, Create object to return
    $result = array();
    $result['estimateIsExact'] = $results['estimateIsExact'];
    $result['estimatedTotalResultsCount'] = $results['estimatedTotalResultsCount'];
    $result['startIndex'] = $start + 1;
    
    $searchResultQuery = "SELECT * FROM 06_google_cache WHERE `query` = '$searchQuery' AND `start`= '$start'";
    $searchResults = getAssoc($searchResultQuery);
    $result['endIndex'] = $start + count($searchResults);
    $result['resultElements'] = $searchResults;
    return $result;
  }else
  {
    //Save results
    $result = runGoogleSearch(&$client, $searchQuery, $start);
    
    if ($client->fault) 
    {
  	  return $result;
    } else {
  	
    	if ($client->getError()) 
    	{
    		return $result;
    	} else 
    	{
    	  $linkID = db_connect();
    		$queryResults = $result['resultElements'];
    		$query = mysql_escape_string($searchQuery);
    		$index = 0;
    		
    		$insertQuery = "REPLACE INTO 06_google_cache_meta 
    		(`key`, `query`, `start`, `estimateIsExact`, `estimatedTotalResultsCount`, `time`)
    		VALUES
    		('$key', '$query', '$start', '{$result['estimateIsExact']}', '{$result['estimatedTotalResultsCount']}', null)";
    		insertQuery($insertQuery);
    		
    		if (count($queryResults) > 1)
    		{
          foreach($queryResults as $item)
          {
            
            $url = mysql_escape_string($item['URL']);
            $snippet = mysql_escape_string($item['snippet']); 
            $title = mysql_escape_string($item['title']);
            $key = md5($start . $index . $query);
            
            $insertQuery = "REPLACE INTO 06_google_cache 
            (`key`, `index`, `query`, `start`, `snippet`, `title`, `url`) 
            VALUES 
            ('$key', '$index', '$query', '$start', '$snippet', '$title', '$url')";
            replaceQuery($insertQuery, $linkID);
            $index++;
          }
        }
        return $result;
      }
    }
  }
  
}

function getSuggested($query)
{
  $suggestions = array();
  $query = explode(" ", $query);
  $linkID = db_connect();
  foreach($query AS $word)
  {
    $word = mysql_real_escape_string($word, $linkID);
    $query = "SELECT * FROM 06_google_suggest WHERE `word` = '$word'";
    $suggest  = getAssoc($query, 2);
    if (count($suggest) > 0)
    {
      foreach ($suggest as $suggestion)
      {
        $suggestions[] = $suggestion;
        echo "Added a suggestion";
      }   
    }
  }
  return $suggestions;
}

?>
</body>
</html>