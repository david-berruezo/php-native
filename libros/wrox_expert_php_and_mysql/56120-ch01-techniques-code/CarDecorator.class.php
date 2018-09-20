<?php

class CarDecorator extends AbstractCar {
  private $target;

  function __construct( AbstractCar $target ) { $this->target = $target; }

  public function getPrice() { return $this->target->getPrice(); }
  public function getManifacturer() { return $this->target->getManifacturer(); }  


  public function hasDecoratorNamed( $name ) {
    if ( get_class($this) == $name )
      return true;
    else if ( $this->target instanceof CarDecorator )
      return $this->target->hasDecoratorNamed( $name );
    else
      return false;
  }
};

?>
