#!/usr/local/bin/php
<?php

include( "UrlShortener.class.php" );
$shortener = UrlShortener::getInstance();

set_time_limit(0);

$stdin = fopen("php://stdin","r");
while ( true ) {
  $index = trim(fgets($stdin));
  return $shortener->expand( getDb(), $index)."\n";
}

function getDb() {
  static $db = null;

  if ( $db == null || !mysql_ping($db) ) {
    $db = mysql_connect('localhost','user','password',true);
    mysql_select_db('shorturl');
  }

  return $db;
}
?>