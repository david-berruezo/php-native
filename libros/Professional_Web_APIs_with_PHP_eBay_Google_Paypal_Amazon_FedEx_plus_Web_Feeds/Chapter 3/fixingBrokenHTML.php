<?php
$brokenHTML = file_get_contents('./broken.html');
$config = array('indent' => TRUE,
               'output-html' => TRUE,
               'wrap' => 200,
               'clean' => TRUE);
$tidy = tidy_parse_string($brokenHTML, $config, 'UTF8');
tidy_clean_repair($tidy);
echo tidy_get_output($tidy); 

function processRSSFeed($xml, $source)
{
  $updatedStories = 0;
  foreach($xml->channel->item AS $story)
  {
    $content = $story->children( "http://purl.org/rss/1.0/modules/content/" );
    $storyContent = $content->encoded;
    if (saveFeed($story->guid, $source, $story->title, $story->pubDate, $storyContent, $story->link) == 2)
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
  //We still don't want any HTML tags in the title of the item
  $title = mysql_real_escape_string(strip_tags($title));
    
  //Clean broken HTML first, to avoid problems with other steps
  $config = array('indent' => TRUE,
             'output-html' => TRUE,
             'wrap' => 200,
             'clean' => TRUE,
             'show-body-only' => TRUE);
    $tidy = tidy_parse_string($content, $config, 'UTF8');
    tidy_clean_repair($tidy);
    $content = tidy_get_output($tidy);
    //Confirm HTML links are absolute, and append the url to the link
    $content = preg_replace('/<a\s+.*?href=[\"\']?([^\"\'>]*)[\"\']?\s?(title=[\"\']?([^\"\'>]*)[\"\']?)?[^>]*>(.*?)<\/a>/ie',
             "cleanAndDisplayHREF('$source', '\\1', '\\3', '\\4')",
             $content);
    //Display images as images, but load from local server
    $content = preg_replace('/<img\s+.*?src="([^\"\' >]*)"\s?(width="([0-9]*)")?\s?(height="([0-9]*)")?[^>]*>/ie',
             "retreiveImages('$source', '\\0','\\1','\\2','\\3','\\4', '\\5')",
             $content);
                
    $content = mysql_real_escape_string(strip_tags($content, "<p><img><a>"));
    $link = mysql_real_escape_string($link);
    $source = mysql_real_escape_string($source);
    
    $date = strtotime($date);
    if ($date == -1)
    {
      $date = time();
    }
        
    $query = "REPLACE INTO 03_feed_raw 
    (`id`, `source`, `title`, `date`, `content`, `link`)
    VALUES 
    ('$pk', '$source', '$title', FROM_UNIXTIME('$date'), '$content', '$link')"; 
    return replaceQuery($query, $linkID);
   }


?>