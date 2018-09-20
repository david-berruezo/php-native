<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 8:22
 */
require_once "vendor\autoload.php";
use clases\userDAO;
define('DB_USER', 'root');
define('DB_PASS', 'Berruezin23');
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'designpatterns');
$user             = new userDAO();
$userDetailsArray = $user->fetch(1);
$updates = array('id' => 1, 'firstname' => 'Pepe');
$user->update($updates);
$allAarons = $user->getUserByFirstName('Antonio');
?>