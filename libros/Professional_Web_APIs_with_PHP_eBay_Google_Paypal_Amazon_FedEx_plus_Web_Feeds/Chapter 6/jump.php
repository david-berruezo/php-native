<?php
require("../common_db.php");
$linkID = db_connect();
$DIRTYtarget = $_GET['t'];
$query = mysql_real_escape_string($_GET['q'], $linkID);
$target = mysql_real_escape_string($DIRTYtarget, $linkID);
$ip = $_SERVER['REMOTE_ADDR'];
$query = "INSERT INTO 06_google_cache_clicked (time, query, url, ip)
  VALUES(null, '$query', '$target', '$ip')";
insertQuery($query);
header("Location: $DIRTYtarget");
?>