<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 08/07/2016
 * Time: 7:49
 */
require("singleton.php");
class CD
{
    protected $_title = "";
    protected $_band = "";
    public function __construct($title, $band)
    {
        //$this-> title = $title;
        //$this-> band = $band;
    }
    public function buy()
    {
        // Singleton
        //$inventory = InventoryConnection::getInstance();
        //$inventory-> updateQuantity($this- > band, $this- > title, -1);
    }
}