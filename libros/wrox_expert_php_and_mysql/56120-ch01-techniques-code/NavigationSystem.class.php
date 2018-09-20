<?php
include_once('CarDecorator.class.php');

class NavigationSystem extends CarDecorator {
  public function getPrice() { return parent::getPrice()+1000; }
};

?>
