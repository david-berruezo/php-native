<?php
  include('class.Lion.php');
  $objLion = new Lion();
  $objLion->weight = 200;   //kg = \s450 lbs.
  $objLion->furColor = 'brown';
  $objLion->maneLength = 36; //cm = \s14 inches
  $objLion->eat();
  $objLion->roar();
  $objLion->sleep();
?>