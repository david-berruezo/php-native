<?php

class TestTarget {
  public $var1 = "hello";
  public function sayHello( $t ) { echo "{$this->var1} $t"; }
};

include_once("LoggingProxy.class.php");

$target = new TestTarget();

$proxy = new LoggingProxy( $target );

echo $proxy->var1."\n";

$proxy->sayHello("Andrew");
echo "\n";

$proxy->var1 = "goodbye";

$proxy->sayHello("Andrew");
echo "\n";

?>
