<?php
require_once("config.php");
require_once("classes/Links.php");

$links = new Links();
$linksList = $links->displayChannel("news");
echo $linksList;
?> 