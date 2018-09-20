<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 30/08/2016
 * Time: 13:27
 */
namespace clases;
class InventoryConnection{
    protected static $_instance = NULL;
    protected $_handle          = NULL;
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    protected function __construct()
    {
        $this->_handle = mysqli_connect("localhost", "root", "Berruezin23", "designpatterns");
        if (!$this->_handle) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL."<br>\n";
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL."<br>\n";
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL."<br>\n";
            exit;
        }
        echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL ."<br>\n";
        echo "Host information: " . mysqli_get_host_info($this->_handle) . PHP_EOL."<br>\n";
    }
    public function updateQuantity($band, $title, $number)
    {
        $query  = "update singleton set amount = ".intval($number);
        $query .= " where band = \"$band\"";
        $query .= " and title = \"$title\"";
        echo $query."<br>\n";
        if ($this->_handle->query($query) === TRUE) {
            echo "Record updated successfully"."<br>\n";
        } else {
            echo "Error updating record: " . $this->_handle->error."<br>\n";
        }
        mysqli_close($this->handle);
    }
}
?>