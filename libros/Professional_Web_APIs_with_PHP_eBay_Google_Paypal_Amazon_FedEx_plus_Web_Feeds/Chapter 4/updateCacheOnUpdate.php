<?php
function cacheIsRecent()
{
  $db = sqlite_open("/tmp/11.timedcache.sqlite"); 
  $query = "SELECT tstamp FROM timedCache WHERE id = 1";
  $result = sqlite_query($db, $query);
  $row = sqlite_fetch_array($result);
  if (time() - $row['tstamp'] > (60 * 10))
  {
    return false; 
  }else
  {
     return true;
  }
}
?>