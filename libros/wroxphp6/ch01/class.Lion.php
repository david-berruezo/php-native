<?php
  require_once('class.Cat.php');
  class Lion extends Cat {
    public $maneLength; //in cm
    public function __construct() {
      $this->maxSpeed = 75;
    }
    public function roar() {
      print "Roarrrrrrrrr!";
    }
    public function getName(){
      return get_class($this);
    }
  }
?>