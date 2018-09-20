<?php
  include ("../common_db.php");
  $subscribers = array();
  array_push($subscribers, array('email' => "paul@example.com", 'format' => 1));
  array_push($subscribers, array('email' => "joe@example.com", 'format' => 0));
  $query = "SELECT id, source, title, DATE_FORMAT(date,'%a, %d %b %Y %T EST') as 
    date, link, content FROM 03_feed_raw WHERE (NOW() - `date`) < 86400";
  $updatedFeeds = getAssoc($query);
  //Produce HTML Version
  $htmlUpdate = "<html><body>";
  foreach ($updatedFeeds as $item)
  {
    $htmlUpdate .= "<h3>{$item['title']}</h3>\r\n";
    $htmlUpdate .= "<font size=-1>{$item['date']}</font>\r\n";
    $htmlUpdate .= "<p>{$item['content']}<br>\r\n";
    $htmlUpdate .= "<a href=\"{$item['link']}\" title=\"Full Story\">{$item['link']}</a></p>\r\n";
    $htmlUpdate .= "<br><br>\r\n";
  }
  $htmlUpdate .= "<p>This email is sent as a service of example-corp. If you no longer wish to receive it, or wish to change subscription options please contact the help desk</p>";
  $htmlUpdate .= "</body></html>\r\n";
  //Produce Plain Text Version
  $plainUpdate = strip_tags($htmlUpdate);
  $htmlHeaders  = "MIME-Version: 1.0\r\n";
  $htmlHeaders .= "From: Daily Feed Updates <dailyfeed@example.com>\r\n";
  $htmlHeaders .= "Content-type: text/html; charset=UTF-8\r\n";
  $plainHeaders = "MIME-Version: 1.0\r\n";
  $plainHeaders .= "From: Daily Feed Updates <dailyfeed@example.com>\r\n";
  $error = "";
  foreach($subscribers as $individual)
  {
    if($individual['format'] == 1)
    {
      if (!mail($individual['email'], "Daily Feeds", $htmlUpdate, $htmlHeaders))
       {
         $error .= "Error To:{$individual['email']}, Content: $htmlHeaders\n";
       }
    }else if ($individual['format'] == 0)
    {
       if (!mail($individual['email'], "Daily Feeds", $plainUpdate, $plainHeaders))
       {
         $error .= "Error To: {$individual['email']}, Content: $plainUpdate\n";
       }
    }
  }
  if (!($error == ""))
  {
    $error = "Messages could not be delivered because the MTA could not be contacted\r\n" . $error;
    file_put_contents("/tmp/feeederrors.txt", $error); 
    echo "$error";
  }
?>
