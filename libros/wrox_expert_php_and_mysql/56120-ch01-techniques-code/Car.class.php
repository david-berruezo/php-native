<?php

include_once('AbstractCar.class.php');

class Car extends AbstractCar {
  private $price = 16000;
  private $manifacturer = "Acme Autos";

  public function getPrice() { return $this->price; }
  public function getManifacturer() { return $this->manifacturer; }
};

?>
