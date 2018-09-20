<?php
function cacheIsRecentExists()
{
  $db = sqlite_open("/tmp/11.timedcache.sqlite"); 
  $query = "SELECT tstamp FROM timedCache WHERE id = 1";
  $result = sqlite_query($db, $query);
  if (sqlite_num_rows($result) == 1)
  {
    return true; 
  }else
  {
    return false;
  }
}
?>