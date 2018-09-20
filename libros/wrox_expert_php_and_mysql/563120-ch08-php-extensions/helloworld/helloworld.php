<?php
$complex = new ComplexGreeter();

echo $complex->sayGreeting("Reader",true).$complex->separator;

$authors = array (
  "Andrew", "Patrick", "Ronald"
);

echo implode( $complex->arraySay($authors), $complex->separator ).$complex->separator;

// Database info
$host = "localhost";
$user = "tester";
$password = "password";

$mysql = new MySQLi($host, $user, $password, "test" );
$result = $mysql->query("SELECT `name` FROM `people`");

echo $complex->mysqliSay( $result, "name", ComplexGreeter::OUTPUT_STRING );

ini_set("helloworld.greeting", "Goodbye");

$complex->sayGreeting("Reader");
echo "\n";
?>
