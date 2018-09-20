<?php
class SimpleEncryption {
  protected $mode;
  protected $cipher;
  protected $secret = "tHiS-1s-a-SeCret!";

  public function __construct( $cipher=MCRYPT_RIJNDAEL_256,
                               $mode=MCRYPT_MODE_CBC ) {
    $this->cipher = $cipher;
    $this->mode = $mode;
  }

  public function getIV() {
    static $iv = false;
    if ( $iv !== false ) return $iv;
    $iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
    srand();
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return $iv;
  }

  public function encrypt( $source ) {
    return mcrypt_encrypt($this->cipher, $this->secret,
                          $source, $this->mode, $this->getIV());

  }

  public function decrypt( $data ) {
    return mcrypt_decrypt( $this->cipher, $this->secret, $data,
                            $this->mode, $this->getIV() );
  }
};
?>