<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 30/05/2016
 * Time: 18:02
 */
require_once('class.Cat.php');
class Tiger extends Cat {
  public $numberOfSpots;
  public $shapeOfSpots = 'lines';
  public function __construct() {
    $this->maxSpeed = 50;

  }
  public function getName(){
      return get_class($this);
  }

}
?>