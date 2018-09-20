<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 10:09
 */
namespace clases;
class logToCSVAdapter extends errorObject
{
    private $__errorNumber, $__errorText;
    public function __construct($error)
    {
        parent::__construct($error);
        $parts = explode(':', $this->getError());
        $this->_errorNumber = $parts[0];
        $this->_errorText   = $parts[1];
    }
    public function getErrorNumber()
    {
        return $this->_errorNumber;
    }

    public function getErrorText()
    {
        return $this->_errorText;
    }
}
?>