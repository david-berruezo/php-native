<?php
class SessionNonce {
  private $salt;

  public function __construct( $salt = "abc123" ) {
    session_start();
    $this->salt = $salt;
    if ( !array_key_exists('nonce',$_SESSION) )
      $this->generate();
  }

  public function consume( $nonce ) {
    if ( $nonce == $_SESSION['nonce'] )
      $this->generate();
    else
      throw new Exception("Invalid nonce");
  }

  private function generate() {
    $_SESSION['nonce'] = MD5(uniqid().$salt.rand(1,1000));
  }

}
?>