<?php
include("CommandLineApplication.class.php");

class CliCrypt extends CommandLineApplication {

  public $cipher=MCRYPT_RIJNDAEL_256, $mode=MCRYPT_MODE_CBC;
  public $secret="expertPHPandMySQL2009!", $interactive = false, $iv = null, $decrypt = false, $list = false;

  public function __construct() {
    parent::__construct();

    $this->registerParameter("c","cipher",true,
           "The cipher to use. Use the -l option to list all valid ciphers.",
           array($this,"isValidCipher"));

    $this->registerParameter("m","mode",true, "The encoding mode to use.", array($this,"isValidMode"));

    $this->registerParameter("I","iv",true, "The initization vector to use.", array($this,"isValidIV"));

    $this->registerParameter("s","secret",true, "The secret key to use.","strlen");

    $this->registerParameter("i","interactive",false, "Use interactive encrytion.");

    $this->registerParameter("l","list",false, "Lists all valid encoding modes.");

    $this->registerParameter("d","decode",false, "Decode the data instead of encoding it. Must specify an IV for some ciphers and modes.");

  }

  public function isValidIV( $iv ) {
    return ( strlen($iv) != mcrypt_get_iv_size($this->cipher, $this->mode) );
  }

  public function isValidCipher( $cipher ) {
    return in_array($cipher, mcrypt_list_algorithms());
  }

  public function isValidMode( $mode ) {
    return in_array($mode, mcrypt_list_modes());
  }

  public function run() {
    parent::run();

    if ( $this->list )
      $this->runList();

    else if ( $this->interactive )
      $this->runInteractiveMode();
    else
      echo $this->crypt();
  }

  private function runList() {
    $ciphers = mcrypt_list_algorithms();

    foreach ( $ciphers as $cipher ) echo "$cipher\n";

  }

  private function runInteractiveMode() {
    $defaultCipher = $this->cipher;
    do {
      $this->cipher = $this->prompt("Choose a cipher",$defaultCipher);
    } while ( !$this->isValidCipher( $this->cipher ) );

    $defaultMode = $this->mode;
    do {
      $this->mode = $this->prompt("Choose an encoding mode",$defaultMode);
    } while ( !$this->isValidMode( $this->mode ) );

    $defaultSecret = $this->secret;
    do {
      $this->secret = $this->prompt("Choose an encryption key/secret",$defaultSecret);
    } while ( strlen( $this->secret ) == 0 );

    while ( count($this->data) == 0 ) {
      $data = $this->prompt("Enter the data that you would like to encrypt");
      if ( $data ) $this->data = array($data);
    }

    echo $this->crypt();
  } 

  private function crypt() {
    if ( $this->iv == null ) {
      $iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
      srand();
      $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    }

    $data = implode(' ',$this->data);

    if ( $this->decrypt ) return $this->doDecrypt( base64_decode($data) )."\n";
    else return base64_encode($this->doEncrypt( $data ))."\n";
  }

  private function doEncrypt( $source ) {
    return mcrypt_encrypt($this->cipher, $this->secret,
                          $source, $this->mode, $this->iv);

  }

  private function doDecrypt( $data ) {
    return mcrypt_decrypt( $this->cipher, $this->secret, $data,
                           $this->mode, $this->iv );
  }



};

$console = new CliCrypt();

$console->run();

?>