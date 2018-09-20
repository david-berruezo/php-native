<?php
  include ("../common_db.php");
  $request = "http://rss.news.yahoo.com/rss/software";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  echo "Updated " . processRSSFeed($xml, $request) . " feeds";
  
function processRSSFeed($xml, $source)
{
  $updatedStories = 0;
  foreach($xml->channel->item AS $story)
  {
    if (saveFeed($story->guid, $source, $story->title, $story->pubDate, 
      $story->description, $story->link) == 2)
    {
      break;
    }
    $updatedStories += 1;
  }
    return $updatedStories;
}

function saveFeed($guid, $source, $title, $date, $content, $link)
{
  if (strlen($guid) > 0)
  {
    $pk = md5($source . $guid);
  }else
  {
    $pk = md5($source . $title);
  }
  $linkID = db_connect();
  $title = mysql_real_escape_string(strip_tags($title));
  $content = mysql_real_escape_string(strip_tags($content));
  $link = mysql_real_escape_string($link);
  $source = mysql_real_escape_string($source);
  $date = strtotime($date);
  if ($date == -1)
  {
    $date = date();
  }    
  $query = "REPLACE INTO 03_feed_raw 
  (`id`, `source`, `title`, `date`, `content`, `link`)
  VALUES 
  ('$pk', '$source', '$title', FROM_UNIXTIME('$date'), '$content', '$link')"; 
  return replaceQuery($query, $linkID);
    
}

function processAtomFeed($xml, $source)
{
  $updatedStories = 0;
  foreach($xml->entry AS $story)
  {
    if (saveFeed($story->id, $source, $story->title, $story->issued, 
      $story->content, $story->link) == 2)
    {
      break;
    }
    $updatedStories += 1;
  }
  return $updatedStories;
}


function processRSSFeedWithEnclosure($xml, $source)
{
  $updatedStories = 0;
  $MaxSize = 1000000;
  foreach($xml->channel->item AS $story)
  {
    if (saveFeed($story->guid, $source, $story->title, $story->pubDate, 
      $story->description, $story->link) == 2)
    {
      break;
    }else if (isset($story->enclosure['url']) && isset($story->enclosure['length']) 
      && ($story->enclosure['length'] < $MaxSize))
    {   
      $filename = basename($story->enclosure['url']);
      $file = file_get_contents($story->enclosure['url']);
      file_put_contents("/tmp/" . $filename, $file);
    }
    $updatedStories += 1;
  }
  return $updatedStories;
}


?>
