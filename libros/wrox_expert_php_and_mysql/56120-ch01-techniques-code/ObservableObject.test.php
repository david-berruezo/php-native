<?php

include_once("Observer.interface.php");
include_once("ObservableObject.class.php");

class TestObserver implements Observer {

  public function notify( $event ) {
    echo "Notified of event\n";
  }

};


$observer = new TestObserver();
$object = new ObservableObject();

$object->observe($observer);
$object->dispatch( null );

?>
