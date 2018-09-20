<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 9:34
 */
namespace clases;
class logToConsole
{
    private $__errorObject;
    public function __construct($errorObject)
    {
        $this->_errorObject = $errorObject;
    }
    public function write()
    {
        fwrite(STDERR,$this->_errorObject->getError());
    }
}
?>