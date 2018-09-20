<?php
	// Page 24
  $request = "http://rss.news.yahoo.com/rss/software";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  echo "<h1>{$xml->channel->title}</h1>";
  foreach($xml->channel->item AS $story)
  {
    echo "<a href=\"$story->link\" title=\"\">$story->title</a><br>"; 
    echo "<p>$story->description</p><br><br>";
  }
?>