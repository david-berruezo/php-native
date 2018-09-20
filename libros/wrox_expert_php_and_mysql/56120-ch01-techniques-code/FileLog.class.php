<?php
class FileLog {
  private $fpointer;
  private $filename;

  function __construct( $filename ) {
    $this->filename = $filename;
    $this->fpointer = fopen($filename,'a');
  }

  function __destruct() {
    fclose($this->fpointer);
  }

  function __sleep() {
    return array( "filename" );
  }

  function __wakeup() {
    $this->fpointer = fopen($this->filename,'a');
  }

  public function write( $line ) {
    fwrite( "$line\n", $this->fpointer );
  }
};

/*
  Example usage:
    $log = new FileLog( "debug.txt" );
    $data = serialize( $log );
    $log = null;
    $log = unserialize($data);
    echo $data;
  Example output:
    O:7:"FileLog":1:{s:17:"FileLogfilename";s:9:"debug.txt"}
*/

?>