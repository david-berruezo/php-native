<?php
$x = "hello";

function hello($name) { echo "Hello $name\n"; }
$x("Andrew"); // Output: "Hello Andrew"

$obj = new StdClass();
$obj->$x = "Test Hello";
echo "{$obj->hello}\n"; // Output: "Test Hello"

class say {
  public static function hello($name) { echo "Hello $name\n"; }
}
say::$x("Boston"); // Output: "Hello Boston"
?>
