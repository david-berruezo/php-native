<?php
$i = 0;

$lambda1 = function() use ($i) { echo "$i"; };
$lambda2 = function() use (&$i) { echo "$i"; };

for ( $i=1; $i<=5; $i++ ) {
  $lambda1();
  $lambda2();
}
// Output: 0102030405
?>
