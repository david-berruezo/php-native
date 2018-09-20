<?php
	header("Content-Type: text/xml");
?><rss version="2.0"> 
  <channel> 
    <language>en</language> 
    <title>Simple Blog</title>
    <description>My Simple blog example.</description> 
    <link>http://example.preinheimer.com/blog/</link>
    <image> 
      <title>Simple Blog Logo</title> 
      <link>http://example.preinheimer.com/feed1.php</link>
      <url>http://example.preinheimer.com/feed1.png</url> 
    </image><?php
    include("./common_db.php");
    $query = "SELECT subject, id, post, email, name, category, 
    DATE_FORMAT(date,'%a, %d %b %Y %T EST') as date
    FROM 03_simple_blog ORDER BY id DESC";
    $recipies = getAssoc($query);
    $url = "http://example.preinheimer.com/blog/index.php?post=";
    foreach($recipies AS $item)
    {
      echo "<item>\n";
      echo "<title>{$item['subject']}</title>\n";
      echo "<link>$url{$item['id']}</link>\n";
      echo "<description>{$item['post']}</description>\n";
      echo "<author>{$item['email']}</author>\n";
      echo "<category>{$item['category']}</category>\n";
      echo "<pubDate>{$item['date']}</pubDate>\n";
      echo "</item>\n";
    }
    echo "</channel>\n</rss>";
  
?>