 <?php

error_reporting(E_ALL);

require_once 'ReferenceCollection.php';

$container = new ReferenceCollection();

$var1 = "aaaa";
$var2 = $var1;
$var3 =& $var1;
$var4 = "bbbb";

$container->add($var1);

echo "contains var1: " . $container->contains($var1) . "<br/>";
echo "contains var2: " . $container->contains($var2) . "<br/>";
echo "contains var3: " . $container->contains($var3) . "<br/>";
echo "contains var4: " . $container->contains($var4) . "<br/>";

// remove $var1
$container->add($var2);
$container->remove($var1);

echo "contains var1: " . $container->contains($var1) . "<br/>";
echo "contains var2: " . $container->contains($var2) . "<br/>";

// play with object

$obj1 = new stdClass();
$obj1->foo = 'bar';
$obj2 = $obj1;

$obj3 = new stdClass();
$obj3->foo = 'bar';

$container->add($obj1);

echo "contains obj1: " . $container->contains($obj1) . "<br/>";
echo "contains obj2: " . $container->contains($obj2) . "<br/>";
echo "contains obj3: " . $container->contains($obj3) . "<br/>";