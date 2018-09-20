<?php

class CommandLineApplication {
  private $argumentsShort = array();
  private $argumentsLong = array();
  private $arguments = array();
  private $appPath;
  protected $data = array();

  public function __construct() {}

  protected function registerParameter( $shortArgument, $longArgument, $hasValue, $help, $validationFunc=null ) {
    $arg = new CommandLineArgument(  $shortArgument, $longArgument, $hasValue, $help, $validationFunc );

    if ( strlen($shortArgument) > 0 ) $this->argumentsShort[ $shortArgument ] = $arg;
    if ( strlen($longArgument) > 0 ) $this->argumentsLong[  $longArgument ]  = $arg;
    $this->arguments[] = $arg;
  }

  public function run() {
    global $argv;
    $this->appPath = array_shift($argv);
    $this->processArguments( $argv );
  }

  private function processArguments( array $_argv ) {
    if ( $item = array_shift($_argv) ) {
      
      if ( $item{0} == '-' ) {

        if ( strlen($item) > 1 && $item{1} == '-' )
          $arg = @$this->argumentsLong[ substr($item,2) ];

        else {
	  $parts = str_split( substr($item,1) );

	  if ( count( $parts ) == 1 ) {
            $arg = @$this->argumentsShort[ $parts[0] ];

          } else {
 	     while ( $arg = array_pop( $parts ) )
	       array_unshift( $_argv, "-$arg" );
 
	     $this->processArguments( $_argv ); 
	     return;
          }

        }

	    $data = null;

        if ( $arg && $arg->hasValue && !($data = array_shift($_argv)) ) {
          $this->showHelp();
	      exit;
        }

        if ( $arg && $arg->validate($data) ) {
          $key = ( strlen($arg->long) > 0 ? $arg->long : $arg->short );
	  if ( $data ) $this->$key = $data;
          else $this->$key = true;
        } else {
          $this->showHelp();
	  exit;
        }

      } else {
        $this->data[] = $item;
      }

      $this->processArguments( $_argv );
    }
  }

  public function showHelp() {
    global $argv;
    echo "Usage: {$this->appPath} ";

    $short = "[-";
    foreach ( $this->arguments as $arg ) {
      if ( strlen($arg->short) > 0 ) $short .= $arg->short;
    }

    if ( strlen($short) > 2 ) echo "$short]";
    echo " data\n";

    foreach ( $this->arguments as $arg ) {
      if ( strlen($arg->short) > 0 ) echo " -{$arg->short}";
      if ( strlen($arg->long) > 0 ) echo " --{$arg->long}";
      echo "\t{$arg->help}\n";
    }
  }

  protected function prompt($message, $default = null) {
    echo $message;
    if ( $default ) echo " [$default]";
    echo ": ";
    $line = $this->readln();
    return ( $line ? $line : $default );
  }

  protected function readln() {
    return trim(fgets(STDIN)); 

  }

};

class CommandLineArgument {

  public $short, $long, $hasValue, $help, $validationFunc;

  public function __construct( $shortArgument, $longArgument, $hasValue, $help, $validationFunc ) {
     $this->short = $shortArgument;
     $this->long = $longArgument;
     $this->hasValue = $hasValue;
     $this->help = $help;
     $this->validationFunc = $validationFunc;
  }

  public function validate( $value ) {
    if ( $this->validationFunc ) return call_user_func( $this->validationFunc, $value );
    else return true;
  }

};

?>