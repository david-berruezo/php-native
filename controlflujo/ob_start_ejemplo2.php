<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 18/07/2016
 * Time: 6:55
 */
// a.php (this file should never display anything)
include('a.php');
ob_start();
include('b.php');
ob_end_clean();
// b.php
print "b";
die();
?>