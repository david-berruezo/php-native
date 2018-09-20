<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
 <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
 <title>My Sample Blog</title>
 <link rel="alternate" type="application/rss+xml" title="RSS" 
  href="http://example.preinheimer.com/blog/feed.php">
</head>
<body>
<h1>Sample Blog</h1>
<?php
  include("./common_db.php");
  if ($_GET['action'] == "trackback")
  {
    echo "Trackback";
    if ($_POST['url'] == "")
    {
      echo '<?xml version="1.0" encoding="iso-8859-1"?>
      <response>
        <error>1</error>
        <message>URL required</message>
      </response>
      ';
      exit;
    }else if (!is_numeric($_GET['id']))
    {
      echo '<?xml version="1.0" encoding="iso-8859-1"?>
      <response>
        <error>1</error>
        <message>Invalid Trackback ID</message>
      </response>
      ';
      exit;  
    }else
    {
      $id = $_GET['id'];
      $blogName = mysql_escape_string($_POST['blog_name']);
      $title = mysql_escape_string($_POST['title']);
      $excerpt = $_POST['excerpt'];
      if (strlen($excerpt) > 252)
      {
        $excerpt = substr($excerpt, 0, 252) . "...";  
      }
      $excerpt = mysql_escape_string($excerpt);
      $query = "INSERT INTO 03_simple_blog_trackback 
      (`blog_id`, `blogName`, `title`, `url`, `excerpt`) VALUES 
      ('$_GET[id]', '$_POST[blog_name]', '$_POST[title]', '$_POST[url]', 
      '$_POST[excerpt]')";
      insertQuery($query);
      echo '<?xml version="1.0" encoding="iso-8859-1"?>
      <response>
        <error>0</error>
      </response>
      ';
      exit;
    }
  }else if (is_numeric($_GET['entry']))
  {
    $query = "SELECT * FROM 03_simple_blog WHERE id = '{$_GET['entry']}'";   
  }else
  {
    $query = "SELECT * FROM 03_simple_blog ORDER by `id` DESC";
  }
  
  $blogEntries = getAssoc($query,2);
  foreach($blogEntries AS $entry)
  {
    $pageURL = "http://example.preinheimer.com/blog/index.php";
    echo "<h2><a href=\"$pageURL?entry={$entry['id']}\">
      {$entry['subject']}</a></h2>\n";
    echo "<b>{$entry['category']}</b>\n";
    echo "<p>{$entry['post']}</p>\n";
    echo "<a href=\"mailto:{$entry['email']}\">{$entry['name']}</a>\n";
    echo "({$entry['date']})\n<br>";
    echo "<a href=\"$postURL?action=trackback&id={$entry['id']}\">Trackback</a>";
    echo '<!--\n<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
       xmlns:dc="http://purl.org/dc/elements/1.1/"
       xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
     <rdf:Description
       rdf:about="$pageURL?entry=' . $entry['id'] . '"
       dc:identifier="$pageURL?entry=' . $entry['id'] . '"
       dc:title="' . $entry['subject'] . '"
       trackback:ping="$pageURL?action=trackback&id=' . $entry['id'] . '" />
     </rdf:RDF>\n-->';
  }
  
  //echo "<pre>";
  //print_r(parse_url("http://www.preinheimer.com/blog/test/asd"));
  //print_r(parse_url("http://www.preinheimer.com/"));
  //print_r(parse_url("http://www.preinheimer.com"));
  //echo "</pre>";
  
  function checkLinkBack($remoteURL, $localURL)
  {
    $page = implode('', file($remoteURL));
    if (stristr($page, $localURL) != FALSE)
    {
      return true; 
    }else
    {
      return false;
    }
  }
  
  function checkBadWords($excerpt)
  {
    $wordList = array('debt',  'poker', 'weight-loss', 'phentermine', 'diet');
    foreach($wordList as $word)
    {
      if (stristr($excerpt, $word) != FALSE)
      {
        return false;
        exit;
      }
    }
    return true;
  }
  
  function checkURL($remoteURL)
  {
    $urlInfo = parse_url($remoteURL);
    if (str_len($urlInfo['path'] > 1))
    {
      return true;
    }else
    {
      return false; 
    } 
  }
  
  
?>
</body>
</html>   