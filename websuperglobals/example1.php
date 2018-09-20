<?php
require_once("WebServerInfo.class.php");
$obj = new WebServerInfo();
print "<pre>";
print $_SERVER['DOCUMENT_ROOT'];
?>