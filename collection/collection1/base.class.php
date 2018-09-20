<?php
/**
	T. D. Ecommerce Implementation
	for Mambo.
	
	@package Mambo
	@author NHM Tanveer Hossain Khan (Hasan)
	@link mail:admin@we4tech.com
	@link http://we4tech.com
*/

/**
  Class: base
  Description: Base Class
*/
class Base {

  /* @var $get_id Unique id for each class */
  var $get_id;
  
  /**
    Default Constructor
  */
  function Base() {
    $this->get_id=time().uniqid(".");
  }
  
  /**
    Get Base ID (Unique id)
    @return string
  */
  function getId() {
    /* check */
    if(empty($this->get_id)) {
      $this->get_id=time().uniqid(".");
    }

    return $this->get_id;
  }
  
  /**
    Set base id
    @param string
  */
  function setId($id) {
    $this->get_id=$id;
  }
  
  /**
    Base Class caption
    @return string
  */
  function toString() {
    return "base object";
  }

}
?>
