<?php
require_once('class.Cheetah.php');
require_once('class.Lion.php');
  function petTheKitty(Cat $objCat) {
    if($objCat->maxSpeed < 5) {
      $objCat->purr();
    } else {
       print "Can't pet the kitty - it's moving at " .
             $objCat->maxSpeed . " kilometers per hour!";
    }
  }
  // Nuevo Leopardo
  $objCheetah = new Cheetah();
  echo ('Nombre: '.$objCheetah->getName().'<br>');
  echo ('Quien soy: '.$objCheetah->whoAmI());
  petTheKitty($objCheetah);

  // Nuevo Tipo cat
  $objCat = new Cat();
  echo ('Nombre: '.$objCat->getName().'<br>');
  echo ('Quien soy: '.$objCat->whoAmI());
  petTheKitty($objCat);

  // Nuevo Tipo cat
  $objLion = new Lion();
  echo ('Nombre: '.$objLion->getName().'<br>');
  echo ('Quien soy: '.$objLion->whoAmI());
  petTheKitty($objLion);
?>


