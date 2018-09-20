<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 9:33
 */
namespace clases;
class errorObject
{
    private $__error;
    public function __construct($error)
    {
        $this->_error = $error;
}
    public function getError()
    {
        return $this->_error;
    }
}
?>