<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 1/10/17
 * Time: 16:29
 */
include_once("vendor/autoload.php");
use clases\Witbooking;
$witbooking = new Witbooking();
$hotels     = $witbooking->get_hotels();
var_dump($hotels);
?>