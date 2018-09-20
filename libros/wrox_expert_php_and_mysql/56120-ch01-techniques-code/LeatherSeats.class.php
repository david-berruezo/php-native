<?php
include_once('CarDecorator.class.php');

class LeatherSeats extends CarDecorator {
  public function getPrice() { return parent::getPrice()+1500; }
};

?>
