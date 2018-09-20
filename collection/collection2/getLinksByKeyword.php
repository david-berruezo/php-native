<?php
require_once("config.php");
require_once("classes/Links.php");

$newslinks = new Links();
$rowset = $newslinks->getByKeyword("news");


echo "<ul class='linkList'>";
foreach($rowset as $row){
    echo "
    <li>";
    echo "<a href='".$row['url']."' title='".stripslashes($row['description'])."' target='new'>
    ".$row['url']."</a>
    <img src='images/".
    $row['rating']."_stars.gif' alt='Rating: ".
    $row['rating']."' title='Rating: ".
    $row['rating']."' />
    <br />
    <span class='description'>".stripslashes($row['description'])."</span>";
    echo "</li>
    ";
}
echo "</ul>";
?> 