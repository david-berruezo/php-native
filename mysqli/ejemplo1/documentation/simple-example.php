<?php
include('../src/unreal4u/config.php');
include('../src/unreal4u/dbmysqli.php');
$db = new unreal4u\dbmysqli();
$db->supressErrors = true;
$db->keepLiveLog   = true;
echo $db->version();
$db->query('SELECT * FROM products');
echo '<pre>';
print_r($db->dbLiveStats);
echo '</pre>';