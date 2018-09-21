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
	Class: Collection class
	Description: Collection class for Cart object iteration
*/
class Collection extends Base {

  /* Array of Objects */
	var $obj=array();
	
	/* Keys */
	var $keys=array();
	
	/**
    	update Key
	    @access private
    */
	function _update_keys() {
	   $this->keys=array_keys($this->obj);
	}
	
	/**
	   Get Object
	   @return object
	*/
	function get($id) {
    	return $this->obj[$id];
	}
	
	/**
	   @return Object
	*/
	function getItemAt($id) {
	   return $this->obj[$this->keys[$id]];
	}
	
	/**
	 Add to object
	*/
	function add($obj) {
		if(is_object($obj)) {
	    	$this->obj[$obj->getId()]=$obj;
    		$this->_update_keys();
		}
		else {
            $newObj=new DefaultObject($obj);
            $this->obj[$newObj->getId()]=$newObj;
            $this->_update_keys($newObj);
  		}
 	}
 	
 	
 	/**
 	   Add all elements from specified to this collection
 	*/
 	function addAll(&$objs) {
    	// throw new null_impl();
	    $this->_update_keys();
  	}

	/**
    	Clear Collection objects
  	*/
  	function clear() {
	    $this->obj=array();
    	$this->_update_keys();
	}
	
	/**
	   return true if this collection contains the specified element
	   @return boolean
	*/
	function contains(&$obj) {
	   	$state=false;

		$get_id=$obj->getId();
    	$state=array_key_exists($get_id,$this->obj);

	   return $state;
	}
	
	/**
	   	return true if this collection contains all specified collection elements
     	@return boolean
	*/
	function containsAll(&$objs) {
	   	$state=0;
     	// throw new null_impl();
     
     	return $state;
	}

  /**
    Compare the specified collection with this collection
    @return boolean
  */	
	function equals(&$obj) {
	   // throw new null_impl();
	}
	
	/**
	   return true if empty
	   @return boolean
	*/
	function isEmpty() {
	
	   return (($this->size()==0)?1:0);
	}
	
	/**
	   Return iterator for this collection
	   @return iterator;
	*/
	function iterator() {
	   $iterator=new _Iterator($this->obj);
	   
	   return $iterator;
	}
	
	/**
	   Remove Specified object from collection
	*/
	function remove(&$obj) {
	   $get_id=$obj->getId();

	   unset($this->obj[$get_id]);
	   $this->_update_keys();
	}
	
	/**
	   Remove All specified objects
	   @boolean
	*/
	function removeAll(&$objs) {
	   $state=0;
	
  		/* Iterate this collection */
  		$it=$obj->iterator();
  	
  		while($it->hasNext()) {
  	   		$obj=$it->next();
  	   		$this->remove($obj);
  		}
	   
	  	$this->_update_keys();
	  	return $state;
	}
	
	/**
	   Size of collection
	   @return int
	*/
	function size() {
	   return count($this->obj);
	}
	
	/**
	   Return Object Array
	   @return array
	*/
	function toArray() {
	   return $this->obj;
	}
	
}
/* $:END:CLASS:collection:$ */

/**
  Class: iterator
  Description: to iterate collection values
*/

class _Iterator extends base {

    /* collection object */
    var $objs;

    /* pointer */
    var $_pointer=0;

    /* Array keys */
    var $keys=array();

    /**
      Default Constructor
    */
    function _Iterator(&$objs) {
    
      $this->objs=&$objs;
      $this->keys=array_keys($objs);
    }

    /**
      return true if exists more element in collection
    */
    function hasNext() {
      $state=0;

      if($this->_pointer < count($this->objs))
        $state=1;

      return $state;
    }

    /**
      return the next element of collection
    */
    function next() {
      $this->_pointer +=1;

      return $this->objs[$this->keys[$this->_pointer-1]];
    }

    /**
       Removes from the underlying collection the last element returned by the iterator (optional operation).
    */
    function remove() {
      $this->_pointer +=1;

      $this->objs[$this->_pointer-1]=null;
    }
}
/* $:END:CLASS:_iterator:$ */

/**
	Class: DefaultObject
	Description: It will use if there is not defined object
*/
class DefaultObject extends Base {

  	var $value;
  	
  	/**
  	    Default Constructor
  	    @param string
  	*/
	function DefaultObject($val) {
		$this->value=$val;
	}

	/**
	    Get value
	    @return string
	*/
	function getValue() {
		return $this->value;
 	}

}
?>