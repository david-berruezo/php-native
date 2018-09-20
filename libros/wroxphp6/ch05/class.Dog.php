<?php
class Dog {
  private $_onspeak;
  public function __construct($name) {
    $this->_name = $name;
  }
  public function bark() {
    if(isset($this->_onspeak)) {
      if(! call_user_func($this->_onspeak)) {
        return false;
      }
    }
    print "Woof, woof!";
  }
  public function onspeak($functionName, $objOrClass = null) {
    if($objOrClass) {
      $callback = array($objOrClass, $functionName);
    } else {
      $callback = $functionName;
    }
    //make sure this stuff is valid
    if(!is_callable($callback, false, $callableName)) {
      throw new Exception("$callableName is not callable as a parameter to onspeak");
      return false;
    }
    $this->_onspeak = $callback;
  }
}  //end class Dog

//procedural function
function isEveryoneAwake() {
  if(time() < strtotime("today 8:30am")|| time() > strtotime("today 10:30pm")) {
    return false;
  } else {
    return true;
  }
}

// Este si entra la funcion isEveryoneAwake
$objDog = new Dog('Fido');
echo ("El nombre es: " .$objDog->_name. "<br>");
$objDog->onspeak('isEveryoneAwake');
$objDog->bark(); //polite dog

// Este no entra en la funcion isEveryoneAwake
$objDog2 = new Dog('Cujo');
$objDog2->bark(); //always barks!

//Throws exception when onspeak is called.
$objDog3 = new Dog('Lassie');
$objDog3->onspeak('nonExistentFunction', 'NonExistentClass');
$objDog3->bark();
?>