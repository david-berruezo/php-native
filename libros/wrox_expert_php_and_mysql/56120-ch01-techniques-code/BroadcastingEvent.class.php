<?php
class BroadcastingEvent {
  private static $observers = array();

  public static function subscribe( Observer $observer ) {
    self::$observers[] = $observer;
  }

  public function publish() {
    foreach ( self::$observers as $observer )
      $observer->notify( $this );
  }
};
?>
