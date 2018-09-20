<?php

include_once('Car.class.php');
include_once('NavigationSystem.class.php');
include_once('LeatherSeats.class.php');

$car = new Car();
$car = new NavigationSystem( $car );
$car = new LeatherSeats( $car );
echo $car->getPrice()."\n";

?>
