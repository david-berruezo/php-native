<?php
  require_once('class.Cat.php');
  class Cheetah extends Cat {
    public $numberOfSpots;
    public $shapeOfSpots = 'circles';
    public function __construct() {
      $this->maxSpeed = 100;
    }
    public function getName(){
      return get_class($this);
    }
  }
?>