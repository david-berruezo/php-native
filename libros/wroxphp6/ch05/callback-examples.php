<?php
class Bar {
  private $_foo;
  public function __construct($fooVal) {
    $this->_foo = $fooVal;
  }
  public function printFoo() {
    print $this->_foo;
  }
  public static function sayHello($name) {
    print "Hello there, $name!";
  }
}
//procedural function - not part of the Bar class
function printCount($start, $end) {
  for($x = $start; $x <= $end; $x++) {
    print "$x ";
  }
}
/* ex. 1 */
//prints 1 2 3 4 5 6 7 8 9 10
call_user_func('printCount', 1, 10);
/* ex. 2 */
//calls $objBar->printFoo()
$objBar = new Bar('elephant'); 
call_user_func(array($objBar, 'printFoo'));
/* ex. 3 */
//calls Bar::sayHello('Steve')
call_user_func(array('Bar', 'sayHello'), 'Steve');
/* ex. 4 */
//This throws a fatal error "Using $this when not 
//in object context" because the function call 
//is Bar::printFoo, which is not a static method
call_user_func(array('Bar', 'printFoo'));
?>