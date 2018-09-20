<?php

include_once("Observer.interface.php");
include_once("BroadcastingEvent.class.php");

class TestObserver implements Observer {

  public function __construct() {
     BroadcastingEvent::subscribe( $this ); 
  }

  public function notify( $event ) {
    echo "Notified of event\n";
  }
};

$observer = new TestObserver();

$event = new BroadcastingEvent();
$event->publish();

?>
