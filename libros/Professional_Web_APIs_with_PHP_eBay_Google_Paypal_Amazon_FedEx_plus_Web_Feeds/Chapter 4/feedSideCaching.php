<?php
	header("Content-Type: text/xml");
	include("./feedcache.php");
	if (cacheIsRecent())
	{
	  echo getCache();  
	}else
	{
	  ob_start();
?><rss version="2.0"> 
  <channel> 
    <language>en</language> 
    <title>Easy Recipes</title>
    <description>Easy recipes for the computer hacker/culinary slacker.</description> 
    <link>http://example.preinheimer.com/feed1.php</link>
    <image> 
      <title>Easy Recipes</title> 
      <link>http://example.preinheimer.com/feed1.php</link>
      <url>http://example.preinheimer.com/feed1.png</url> 
    </image><?php
    include("./common_db.php");
    $query = "SELECT * FROM 11_basic_feed";
    $recipies = getAssoc($query);
    foreach($recipies AS $item)
    {
      echo "<item>\n";
      echo "<title>{$item['title']}</title>\n";
      echo "<link>{$item['link']}</link>\n";
      echo "<description>{$item['description']}</description>\n";
      echo "<author>{$item['author']}</author>\n";
      echo "<category>{$item['category']}</category>\n";
      echo "<pubdate>{$item['pubdate']}</pubdate>\n";
      echo "</item>\n";
    }
    echo "</channel>\n</rss>";
  updateCache(ob_get_contents());
  ob_end_flush(); 
}
?>
