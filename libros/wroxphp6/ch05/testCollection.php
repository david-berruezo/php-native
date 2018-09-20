<?php
require_once('class.Collection.php');

/* a silly class for testing */
class Foo {
  private $_name;
  private $_number;

  public function __construct($name, $number) {
    $this->_name = $name;
    $this->_number = $number;
  }
  public function __toString() {
    return $this->_name . ' is number ' . $this->_number;
  }
}

$colFoo = new Collection();
$colFoo->addItem(new Foo("Steve", 14), "steve");
$colFoo->addItem(new Foo("Ed", 37), "ed");
$colFoo->addItem(new Foo("Bob", 49));
$objSteve = $colFoo->getItem("steve");
print "El objeto es: " .$objSteve. "<br>"; //prints "Steve is number 14"
$colFoo->removeItem("steve"); //deletes the 'steve' object
try {
  $colFoo->getItem("steve"); //throws KeyInvalidException
} catch (KeyInvalidException $kie) {
  print "The collection doesn't contain anything called 'steve'";
}
?>