<?php
class Cat {
    public $weight;         //in kg
    public $furColor;
    public $whiskerLength;
    public $maxSpeed;       //in km/hr
    public $speciesName;
    public function eat() {
      //code for eating...
    }

    public function sleep() {
      //code for sleeping...
    }

    public function hunt(Prey $objPrey) {
      //code for hunting objects of type Prey
      //which we will not define...
    }

    public function purr() {
      print "purrrrrrr..." . "\n";
    }

    public function getName(){
      return get_class($this);
    }

    public function whoAmI() {
      return get_called_class();
    }

}
?>


