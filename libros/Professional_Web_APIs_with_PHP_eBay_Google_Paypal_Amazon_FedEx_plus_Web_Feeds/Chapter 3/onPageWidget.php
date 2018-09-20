<?php
function getStories($count, $source = "")
{
  $titleLength = 25;
  $storyLength = 100;
  if($source == "")
  {
    $query = "SELECT `title`, `content`, `link` FROM 03_feed_raw ORDER BY `date` DESC LIMIT $count";
  }else
  {
     $query = "SELECT `title`, `content`, `link` FROM 03_feed_raw WHERE source = '$source' ORDER BY `date` DESC LIMIT $count";
  }
  echo $query;
  $stories = getAssoc($query);
  foreach($stories as &$story)
  {
    $story['title'] = substr(strip_tags($story['title']), 0, $titleLength);
    $story['content'] = substr(strip_tags($story['content']), 0, $storyLength);
    echo ".";
  }
  return $stories;
}


function printWidget($count, $source = "")
{
 $stories = getStories($count, $source);
 foreach($stories as $story)
 {
   echo "<a href=\"{$story['link']}\">{$story['title']}</a><br>\n";
   echo "<p>{$story['content']}</p>\n";
 }
}



?>