<?php

class LoggingProxy {
  private $target;

  function __construct( $target ) {
    $this->target = $target;
  }

  protected function log( $line ) {
    error_log($line);
  }

  public function __set( $name, $value ) {
    $this->target->$name = $value;
    $this->log("Setting value for $name: $value");
  }

  public function __get( $name ) {
    $value = $this->target->$name;
    $this->log( "Getting value for $name: $value" );
    return $value;
  }

  public function __isset( $name ) {
    $value = isset($this->target->$name);
    $this->log( "Checking isset for $name: ".($value?"true":"false") );
    return $value;
  }

  public function __call( $name, $arguments ) {
    $this->log( "Calling method $name with: ".implode(",",$arguments) );
    return call_user_func_array( array($this->target,$name), $arguments );
  }

};

?>
