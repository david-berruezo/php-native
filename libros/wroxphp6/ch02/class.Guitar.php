<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 04/06/2016
 * Time: 11:51
 */
class Guitar implements Instrument {
    private $name;
    private $category;
    function __construct($name) {
        $this->name = $name;
        $this->category = "guitar";
    }
    public function getName() {
        return $this->name;
    }
    public function getCategory() {
        return $this->category;
    }
}
?>