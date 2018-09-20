<?php

class MultitonExample {

  public static function getInstance( $key ) {
    static $instances = array();
    if ( !array_key_exists( $key, $instances ) ) {
      $instances[$key] = new MultitonExample();
    }
    return $instances[$key];
  }

};

?>
