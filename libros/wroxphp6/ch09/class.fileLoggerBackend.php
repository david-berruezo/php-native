<?php

require_once('class.LoggerBackend.php');

class fileLoggerBackend extends LoggerBackend {

  private $logLevel;
  private $hLogFile;

  public function __construct($urlData) {
    
    parent::__construct($urlData);
    
    $this->logLevel = Config::getConfig('LOGGER_LEVEL');
    
    $logFilePath = $this->urlData['path'];
    
    if(! strlen($logFilePath)) {
      throw new Exception('No log file path was specified ' .
                  'in the connection string.');
    }
    
    print "Logging data to $logFilePath";
    
    //Open a handle to the log file.  Suppress PHP error messages.
    //We'll deal with those ourselves by throwing an exception.
    $this->hLogFile = @fopen($logFilePath, 'a+');
    
    if(! is_resource($this->hLogFile)) {
    throw new Exception("The specified log file $logFilePath " .
                   'could not be opened or created for ' .
                   'writing.  Check file permissions.');
    }
    
    //Set encoding type to ISO-8859-1
    stream_encoding($this->hLogFile, 'iso-8859-1');

  }

  public function logMessage($msg, $logLevel = LOGGER_INFO, $module = null) {
    if($logLevel > $this->logLevel) {
      return;
    }
      
    /* If you haven't specifed your timezone using the 
     date.timezone value in php.ini, be sure to include
     a line like the following.  This can be omitted otherwise.
    */
    date_default_timezone_set('America/New_York');
    $time = strftime('%x %X', time());
    $msg = str_replace("\t", '    ', $msg);
    $msg = str_replace("\n", ' ', $msg);

    $strLogLevel = Logger::levelToString($logLevel);

    if(isset($module)) {
      $module = str_replace("\t", '    ', $module);
      $module = str_replace("\n", ' ', $module);
    }
    
    //logs: date/time loglevel message modulename
    //separated by tabs, new line delimited
    $logLine = "$time\t$strLogLevel\t$msg\t$module\n";
    fwrite($this->hLogFile, $logLine);
  
  }
}
?>
