<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 02/08/2016
 * Time: 18:54
 */

/*
 * Devuelve la url absoulta
 */
$url = "http://www.davidberruezo.com/projects/index.php";
$url = osc_get_absolute_url();
echo("url: ".$url."<br>\n");

function osc_get_absolute_url() {
    $protocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
}
?>