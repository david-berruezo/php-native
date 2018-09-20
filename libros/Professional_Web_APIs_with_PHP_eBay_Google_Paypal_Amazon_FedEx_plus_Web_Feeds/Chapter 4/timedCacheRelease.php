<?php 
$db = new SQLiteDatabase("/tmp/11.timedcache.sqlite"); 
$db->query("BEGIN; 
  CREATE TABLE timedCache(id INTEGER PRIMARY KEY, cache BLOB, tstamp TEXT); 
  COMMIT;"); 
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

function updateCache($body)
{
  $db = new SQLiteDatabase("/tmp/11.timedcache.sqlite"); 
  $time = time();
  $query = "REPLACE INTO timedCache (id, cache, tstamp) VALUES (1, '$body', '$time')";
  $db->query("BEGIN; $query; COMMIT;");
}

function getCache()
{
  $db = sqlite_open("/tmp/11.timedcache.sqlite"); 
  $query = "SELECT cache FROM timedCache WHERE id = 1";
  $result = sqlite_query($db, $query);
  $row = sqlite_fetch_array($result);
  return $row['cache'];
}

?>