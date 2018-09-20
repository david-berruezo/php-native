<?php
  require_once('class.Demo.v2.php');
  $objDemo = new Demo();
  $objDemo->name = 'Steve';

  $objAnotherDemo = new Demo();
  $objAnotherDemo->name = 'Ed';

  $objDemo->sayHello();
  $objAnotherDemo->sayHello();
?>
