<?php
	include("../common_db.php");
	switch ($_GET['format'])
	{
	 case "atom":
	  displayATOM();
	  break;
	 case "rss":
	 default: 
	  displayRSS();
	  break;
	}

function displayATOM()
{
 header("Content-Type: application/atom+xml");
 $url = "http://example.preinheimer.com/store/index.php";
 $query = "SELECT id, name, email, title, tip, 
  DATE_FORMAT(pubDate,'%Y-%c-%dT%H:%i:%S-04:00') as pubDate
  FROM 03_store_tips ORDER BY pubDate";
  $tips = getAssoc($query, 2);
  ?><?xml version="1.0" encoding="utf-8"?>
  <feed version="0.3" xmlns="http://purl.org/atom/ns#">
   <title>Tom’s Garden Shed</title>
   <link rel="alternate" type="text/html" 
    href="http://example.preinheimer.com/store/index.php" />
   <modified><?php echo $tips[0]['pubDate'] ?></modified>
   <author>
    <name>Tom's Garden Shed</name>
   </author>
	  <?php
	  foreach($tips AS $item)
   { 
    if (strlen($item['tip']) > 252)
    {
     $item['tipTrim'] = substr($item['tip'], 0, 252) . "...";  
    }else
    {
     $item['tipTrim'] = $item['tip'];
    }
    echo "<entry>\n";
    echo "<title>{$item['subject']}</title>";
    echo "<link rel=\"alternate\" type=\"text/html\" href=\"$url?entry={$item['id']}\" />";
    echo "<id>$url?entry={$item['id']}</id>";
    echo "<summary>{$item['tipTrim']}</summary>\n";
    echo "<content>{$item['tip']}</content>";
    echo "<issued>{$item['pubDate']}</issued>";
    echo "<modified>{$item['pubDate']}</modified>";
    echo "</entry>\n";
   }
	  echo "</feed>";
}
	function displayRSS()
	{
	  header("Content-Type: text/xml");
    $query = "SELECT id, name, email, title, tip, 
    DATE_FORMAT(pubDate,'%a, %d %b %Y %T EST') as pubDate
    FROM 03_store_tips ORDER BY pubDate";
    $tips = getAssoc($query, 2);
	 ?><rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"> 
  <channel> 
    <language>en</language> 
    <title>Tom's Garden Shed, Weekly Tips</title>
    <description>Weekly gardening tips from Tom</description> 
    <generator>Tom's Feed Generator, v0.01b</generator>
    <ttl>1440</ttl>
Notice the content XML namespace, this allows us to include the entire post, not just a summary within the feed. I’ve also included the TTL declaration in this script, aggregators should notice this and refresh the feed only once a week. You could also look into the skipDays and skipHours elements to further define this more clearly. 
    <pubDate><?php echo $tips[0]['pubDate'] ?></pubDate>
    <link>http://example.preinheimer.com/store/</link>
    <image> 
      <title>Tom's Garden Shed</title> 
      <link>http://example.preinheimer.com/store/</link>
      <url>http://example.preinheimer.com/store/tom.png</url> 
    </image><?php
    
    foreach($tips AS $item)
    {
      $url = "http://example.preinheimer.com/store/index.php";
      if (strlen($item['tip']) > 252)
      {
        $item['tipTrim'] = substr($item['tip'], 0, 252) . "...";  
      }else
      {
        $item['tipTrim'] = $item['tip'];
      }
      echo "<item>\n";
      echo "<title>{$item['title']}</title>\n";
      echo "<link>$url?item={$item['id']}</link>\n";
      echo "<description>{$item['tipTrim']}</description>\n";
      echo "<content:encoded>{$item['tip']}</content:encoded>";
      echo "<author>{$item['email']}</author>\n";
      echo "<pubDate>{$item['pubDate']}</pubDate>\n";
      echo "</item>\n";
    }
    echo "</channel>\n</rss>";
}
?>