<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 10:04
 */
namespace clases;
class logToCSV
{
    const CSV_LOCATION = 'log.csv';
    private $__errorObject;
    public function __construct($errorObject)
    {
        $this->_errorObject = $errorObject;
    }
    public function write()
    {
        $line = $this->_errorObject->getErrorNumber();
        $line .= ',';
        $line .= $this->_errorObject->getErrorText();
        $line .= "\n";
        file_put_contents(self::CSV_LOCATION, $line, FILE_APPEND);
    }
}
?>