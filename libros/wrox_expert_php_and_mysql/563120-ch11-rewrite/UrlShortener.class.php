<?php

class UrlShortener {
  private $characterMap;
  private $base;
  const OFFSET = 512;
  
  public function __construct() {
    $this->characterMap = array(
      'q', 'w', 'r', 't', 'y', 'p', 's', 'd', 
      'f', 'g', 'h', 'j', 'k', 'L', 'm', 'n',
      '3', '2', '1', 'z', 'x', 'c', 'v', 'b', 
      '4', '5', '9', '6', '8', '7'
    );
    $this->base = sizeof($this->characterMap);
  }

  public static function getInstance() {
    static $instance = null;
    if ( $instance === null ) {
      $instance = new UrlShortener();
    }
    return $instance;
  }

  public function shorten( $conn, $url ) {
    $escapedUrl = mysql_real_escape_string($url, $conn);

    $res = mysql_query(
      "SELECT `id` FROM urls WHERE `url` LIKE '$escapedUrl'",
      $conn
    );

    $row = mysql_fetch_row($res);
    mysql_free_result( $res );
   
    if ( $row )
      return $this->encode( $row[0]+self::OFFSET );
    
    $res = mysql_query(
      "INSERT INTO `urls` (`url`) VALUES('$escapedUrl')",
      $conn
    );
    return $this->encode( mysql_insert_id($conn)+self::OFFSET );
  }

  public function encode( $value ) {
    $value += 512;
    if ( $value < $this->base )
      return $this->characterMap[ $value ];
    else
      return $this->encode( floor($value/$this->base) ).
             $this->characterMap[ $value % $this->base ];
  }

  public function decode( $value ) {
    $decodeMap = array_flip( $this->characterMap );
    $parts = array_reverse( str_split( $value ) );

    $index = 0;
    $i = 0;
    foreach ( $parts as $char ) {
      $index += $decodeMap[$char] * pow( $this->base, $i++ );
    }
    return $index-512;
  }

  public function expand( $conn, $index ) {
    $id = $this->decode( $index )-self::OFFSET;
    $res = mysql_query("SELECT `url` FROM `urls` WHERE `id` = $id", $conn);
    $value = ( ($row = mysql_fetch_row( $res )) ? $row[0] : null );
    mysql_free_result( $res );
    return $value;
  }
};

?>