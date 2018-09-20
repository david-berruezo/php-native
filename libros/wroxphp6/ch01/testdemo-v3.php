<?php
require_once('class.Demo.v3.php');
$objDemo = new Demo();
$objDemo->setName('Steve');
$objDemo->sayHello();
$objDemo->setName(37); //would trigger an error
$nombre = $objDemo->getName();
echo('El nombre es: '.$nombre.'<br>');
$objDemo = null;
$nombre = $objDemo->getName();
echo('Hay nombre: '.$nombre);
?>