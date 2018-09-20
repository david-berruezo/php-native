<?php
include_once('SingletonExample.class.php');

$instance1 = SingletonExample::getInstance();
$instance2 = SingletonExample::getInstance();

echo "Instance 1 ".( $instance1 === $instance2 ? "IS" : "IS NOT" )." the same as Instance 2\n";
?>