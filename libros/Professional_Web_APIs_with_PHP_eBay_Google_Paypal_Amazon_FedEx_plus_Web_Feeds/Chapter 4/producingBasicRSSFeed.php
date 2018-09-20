<?php
	header("Content-Type: text/xml");
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
    $query = "SELECT title, link, description, author, category, 
      DATE_FORMAT(pubdate,'%a, %d %b %Y %T EST') as pubdate
      FROM 11_basic_feed";
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
?></channel>
</rss>


<?php
/*
CREATE TABLE `11_basic_feed` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `link` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `author` varchar(50) NOT NULL default '',
  `category` varchar(25) NOT NULL default '',
  `pubdate` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `11_basic_feed` VALUES (1, 'Cocolate Chip Cookies', 'http://example.preinheimer.com/feed1.php?item=1', '1. Take the tube out of the fridge\r\n2. Place the cookie sheet on the counter\r\n3. Cut the tube open\r\n4. Slice the cookie batter into 12 equally sized peices\r\n5. Place each slice on the cookie sheet\r\n6. Preheat the oven to 350F\r\n7. Place cookie sheet on center rack\r\n8. Wait 20 minutes\r\n9. Remove cookies from oven\r\n10. Burn fingers and enjoy', 'Paul', 'Baking', '20041102202815');
INSERT INTO `11_basic_feed` VALUES (2, 'Waffles', 'http://example.preinheimer.com/feed1.php?item=2', '1. Take box out of freezer\r\n2. Remove two waffles from box\r\n3. Place waffles in toaster\r\n4. Depress button\r\n5. Wait for toaster to pop\r\n6. Remove waffles from toaster, place on plate\r\n7. Pour Canadian Maple Syrup on waffles\r\n8. Enjoy', 'Paul',
'Breakfast', '20041102202815');
*/
?>