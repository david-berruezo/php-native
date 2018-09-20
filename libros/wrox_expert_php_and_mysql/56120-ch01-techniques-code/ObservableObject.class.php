<?php
class ObservableObject {
  private $observers = array();

  public function observe( Observer $observer ) {
    $this->observers[] = $observer;
  }

  public function dispatch( $event ) {
    foreach ( $this->observers as $observer )
      $observer->notify( $event );
  }
};
?>
