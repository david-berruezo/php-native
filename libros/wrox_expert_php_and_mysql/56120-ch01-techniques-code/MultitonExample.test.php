<?php

include_once('MultitonExample.class.php');

$instance1 = MultitonExample::getInstance(1);
$instance2 = MultitonExample::getInstance(1);
$instance3 = MultitonExample::getInstance(2);


function isTheSame( $label1, $obj1, $label2, $obj2 ) {
  echo "$label1 ".( $obj1 === $obj2 ? "IS" : "IS NOT" ).
       " the same as $label2\n";
}

isTheSame( "Instance 1", $instance1, "Instance 2", $instance2 );
isTheSame( "Instance 1", $instance1, "Instance 3", $instance3 );

?>
