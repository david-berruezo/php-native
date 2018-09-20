<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 8:13
 */
namespace clases;
use clases\InventoryConnection;
class CD
{
    protected $_title = "";
    protected $_band  = "";
    public function __construct($title, $band)
    {
        $this->title = $title;
        $this->band  = $band;
    }
    public function buy()
    {
        $inventory = InventoryConnection::getInstance();
        $inventory->updateQuantity($this->band, $this->title, 10);
    }
}
?>