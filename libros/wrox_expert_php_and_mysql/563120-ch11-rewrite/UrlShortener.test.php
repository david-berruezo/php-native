<?php

$conn = mysql_connect('localhost','user','password');
mysql_select_db('short');

$shortener = UrlShortener::getInstance();

$shortUrl = $shortener->shorten( $conn, "http://www.wrox.com" );

echo $shortener->expand( $conn, $shortUrl );

mysql_close( $conn );
?>