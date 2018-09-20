<?php
require_once("class.Collection.php");

class Singer {
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
}

class Waiter {
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
}

class NightClub {
  public $name;
  public $singers;
  public $waiters;
  public function __construct($name) {
    $this->name = $name;
    $this->singers = new Collection();
    $this->waiters = new Collection();
    $this->singers->setLoadCallback('loadSingers', $this);
    $this->waiters->setLoadCallback('loadWaiters', $this);
  }

  public function loadSingers(Collection $col) {
    print "(We're loading the singers!)<br>\n";
    //these would normally come from a database
    $col->addItem(new Singer('Frank Sinatra'));
    $col->addItem(new Singer('Dean Martin'));
    $col->addItem(new Singer('Sammy Davis, Jr.'));
  }

  public function loadWaiters(Collection $col) {
    print "(We're loading the waiters!)<br>\n";
    //these would normally come from a database
    $col->addItem(new Waiter('Alvaro'));
    $col->addItem(new Waiter('Eduardo'));
  }

}
// Accedemos solo a las propiedades del objeto Nigth Club
$objNightClub = new NightClub("Otto");
print "Welcome to " . $objNightClub->name . "<br>\n";

// Accedemos a las propiedes del objeto Night Club y también a la colección singers
$objNightClub = new NightClub("The Sands");
var_dump($objNightClub);
print "Welcome to " . $objNightClub->name ."<br>\n";
print "We have " . $objNightClub->singers->length() . " singers for your listening pleasure this evening<br>\n";
print "We have " . $objNightClub->waiters->length() . " waiters for give you a beverage<br>\n";
?>