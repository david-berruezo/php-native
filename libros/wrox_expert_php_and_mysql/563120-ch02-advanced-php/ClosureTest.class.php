<?php
class ClosureTest {
  public $multiplier;
  public function __construct( $multilier ) {
    $this->multiplier = $multilier;
  }
  public function getClosure() {
    $mul = &$this->multiplier;
    return function( $number ) use( &$mul ) {
      return $mul * $number;
    };
  }
}

$test = new ClosureTest(10);
$x = $test->getClosure();

echo $x(8); // Output: 80
$test->multiplier = 2;
echo $x(8); // Output: 16
?>
