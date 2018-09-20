<?php

	require_once("WebServerInfo.class.php");
	$obj = new WebServerInfo();

	print "<pre>";
  print $obj->get('DOCUMENT_ROOT');
?>