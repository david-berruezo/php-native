<?php

class EmailValidator {
  const CONN_TIMEOUT = 10;
  const READ_TIMEOUT = 5;
  const SMTP_PORT = 25;
  private $email;
  
  public function __construct( $email ) { $this->email = $email; }

  private function getParts() {
    $regex = <<<__REGEX__
/^(?P<user>
  "[\w!#$%&'*+\/=?^`{|}~.@()[\]\\;:,<>-]+" (?# quoted username )
| (?!\.)[\w!#$%&'*+\/=?^`{|}~.-]+(?<!\.)   (?# non-quoted username )
) @ (?P<host>
  (?:(?!-)[\w-]+(?<!-)\.)+(?!-)[\w-]+(?<!-) (?# host )
| \[([0-9]{1,3}\.){3}[0-9]{1,3}\] (?# host IP address )
)$/x
__REGEX__;

    return ( preg_match($regex, $this->email, $matches) ? $matches : null);
  }

  public function isValid( $lazy ) {
    static $valid = null;
    
    if ( $lazy ) return ( $this->getParts() != null );
    if ( $valid !== null ) return $valid;
    $valid = false;

    if ( $parts = $this->getParts() ) {
      $valid = $this->validateUser( $parts['host'], $parts['user'] );
    }
    return $valid;
  }

  private function validateUser( $hostname, $user ) {
    if ( $sock = $this->openSMTPSocket($hostname) ) {
      $this->smtpSend("HELO $hostname");
      $this->smtpSend("MAIL FROM: <$user@$hostname>");
      $resp = $this->smtpSend("RCPT TO: <$user@$hostname>");
  
      $valid = (preg_match('/250|45(1|2)\s/') == 1);
      fclose($fp);
      return $valid;
    } else {
      return false;
    }
  }

  private function smtpSend( $sock, $data ) {
    fwrite($sock, "$data\r\n");
    return fgets($sock, 1024);
  }
  
  private function openSMTPSocket( $hostname ) {
    $hosts = $this->getMX($hostname);
    foreach ( $hosts as $host => $weight ) {
      if ( $sock = @fsockopen($host, self::SMTP_PORT,
           $errno, $errstr, self::CONN_TIMEOUT) ) {
        stream_set_timeout($sock, self::READ_TIMEOUT);
        return $sock;
      }
    }
    return null;
  }

  private function getMX( $hostname ) {
    $hosts = array();
    $weights = array();
    getmxrr( $hostname, $hosts, $weights );
    $results = array();
    foreach ( $hosts as $i => $host )
      $results[ $host ] = $weights[$i];
    arsort($results, SORT_NUMERIC);
    $results[$hostname] = 0;
    return $results;
  }

};
?>
