<?php
require_once('class.Config.php');
require_once('class.Logger.php');

//Again, the implementation of this class is left to the user, but an
//example of how it could work will be provided in the code download
//that accompanies the book on wrox.com
Config::addConfig('LOGGER_FILE', '/var/log/myapplication.log');
Config::addConfig('LOGGER_LEVEL', Logger::INFO);

$log = Logger::getInstance();

  if(isset($_GET['fooid'])) {

    //not written to the log - the log level is too high
    $log->logMessage('A fooid is present', Logger::DEBUG);
  
   //LOG_INFO is the default so this would get printed
    $log->logMessage('The value of fooid is ' .  $_GET['fooid']);

  } else {

    //This will also be written, and includes a module name
    $log->logMessage('No fooid supplied',
                  Logger::CRITICAL,
                 "Foo Module");
    
    throw new Exception('No foo id!');
}
?>