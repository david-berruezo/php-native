<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 08/07/2016
 * Time: 7:47
 */

class InventoryConnection
{
    protected static $_instance = NULL;
    protected $_handle          = NULL;
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    protected function __construct(){
        //$this- > handle = mysql_connect(‘localhost’, ‘user’, ‘pass’);
        //mysql_select_db(‘CD’, $this- > handle);
    }
    public function updateQuantity($band, $title, $number)
    {
        //$query = “update CDS set amount=amount+” . intval($number);
        //$query .= “ where band=’” . mysql_real_escape_string($band) . “’”;
        //$query .= “ and title=’” . mysql_real_escape_string($title) . “’”;
        //mysql_query($query, $this- > handle);
    }
}

