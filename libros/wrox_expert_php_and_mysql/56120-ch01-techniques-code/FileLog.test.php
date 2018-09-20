<?php
  include_once("FileLog.class.php");

  $log = new FileLog( "debug.txt" );
  $data = serialize( $log );
  $log = null;
  $log = unserialize($data);
  echo $data;
?>
