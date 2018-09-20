<?php
include("./common_db.php");
if ($_POST['name'] != "")
{
  $name = $_POST['name']; $email = $_POST['email']; 
  $subject = $_POST['subject']; $category = $_POST['category'];
  $post = $_POST['post']; $date = date('Y-m-d G:i:s');
 
  $query = "INSERT INTO 03_simple_blog 
   (`id`, `name`, `email`, `subject`, `category`, `post`, `date`) 
   VALUES (null, '$name', '$email', '$subject', '$category', '$post', '$date')";
      
  $id = insertQueryReturnID($query);
   
  
  $postURL = "http://example.preinheimer.com/index.php?entry=$id";
  $messages = "Post added, Post id <a href=\"$postURL\">$id</a>";
   
  echo sendTB($_POST['trackback'], $_POST['subject'], $_POST['post'], $postURL);
   
   
}
function sendTB($url, $title, $excerpt, $postURL)
{
  $blogname = urlencode("Simple Blog");
  $title = urlencode($title);
  if (strlen($excerpt) > 252)
  {
    $excerpt = substr($excerpt, 0, 252) . "...";  
  }
  $excerpt = urlencode($excerpt);
  $url_info = parse_url($url);
  $host = $url_info['host'];
  $path = $url_info['path'] . "?" . $url_info['query'];
  $url = urlencode($url);
  $data="tb_url=$url&url=$postURL&blog_name=$blogname&title=$title&excerpt=$excerpt";
  
  $fp=fsockopen($host, 80);
  fputs($fp, "POST " . $path . " HTTP/1.1\r\n");
  fputs($fp, "Host: " . $host ."\r\n");
  fputs($fp, "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain\r\n");
  fputs($fp, "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n");
  fputs($fp, "Connection: close\r\n");
  fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-Length: " . strlen($data) . "\r\n\r\n");
  fputs($fp, "$data");
  
  $response="";
  while(!feof($fp))
  {
    $response.=fgets($fp, 128);
  }
  fclose($fp);
  list($http_headers, $http_content)=explode("\r\n\r\n", $response);
  
  if (substr_count($http_content, "<error>0</error") > 0)
  {
    return "Trackback Successful<br>\n{$http_content}";
  }else if (substr_count($http_content, "<error>1</error") > 0)
  {
    return "Trackback Failed";
  }else
  {
    return "Unrecognized response, Bad URL?<br>\n{$http_content}"; 
  }
  
}
?><html>
<head>
<title>Simple Blog</title>
</head>
<body>
<?php echo $messages; ?>
<form action="#" method="post">
Name: <input type="text" name="name"><br>
Email: <input type="text" name="email"><br>
Subject: <input type="text" name="subject"><br>
Category: <input type="text" name="category"><br>
Trackback: <input type="text" name="trackback"><br>
Post:<br><textarea name="post"></textarea><br>
<input type="submit" value="Submit">
</form>
</body>
</html>