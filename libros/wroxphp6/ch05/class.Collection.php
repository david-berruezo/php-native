<?php
class KeyInUseException extends Exception { }
class KeyInvalidException extends Exception { }

class Collection {
  // Object vars
  private $_members  = array();  // Collection members
  private $_onload;              // Holder for callback function
  private $_isLoaded = false;    // Flag that indicates whether the callback has been invoked
  /*
   * Añadimos item
   */
  public function addItem($obj, $key = null) {
    $this->_checkCallback();      //_checkCallback is defined a little later
    if($key) {
      if(isset($this->_members[$key])) {
        throw new KeyInUseException("Key \"$key\" already in use!");
      } else {
        $this->_members[$key] = $obj;
      }
    } else {
      $this->_members[] = $obj;
    }
  }

  /*
   * Borramos item
   */
  public function removeItem($key) {
    $this->_checkCallback();
    if(isset($this->_members[$key])) {
      unset($this->_members[$key]);
    } else {
       throw new KeyInvalidException("Invalid key \"$key\"!");
    } 
  }

  /*
   * Obtenemos item
   */
  public function getItem($key) {
    $this->_checkCallback();
    if(isset($this->_members[$key])) {
      return $this->_members[$key];
    } else {
      throw new KeyInvalidException("Invalid key \"$key\"!");
    }
  }

  public function getItems(){
    $this->_checkCallback();
    if (sizeof($this->_members)){
      return $this->_members;
    }
  }

  /*
   * Obtenemos todas las llaves
   */
  public function keys() {
    $this->_checkCallback();
    return array_keys($this->_members);
  }

  /*
   * Obtenemos el numero de objetos
   */
  public function length() {
    $this->_checkCallback();
    return sizeof($this->_members);
  }

  /*
   * Devolvemos true si existe el objeto
   * con la clave pasada
   */
  public function exists($key) {
    $this->_checkCallback();
    return (isset($this->_members[$key]));
  }

  /**
  * Use this method to define a function to be
  * invoked prior to accessing the collection.
  * The function should take a collection as a
  * its sole parameter.
  */
  public function setLoadCallback($functionName, $objOrClass = null) {
    if($objOrClass) {
      $callback = array($objOrClass, $functionName);
    } else {
      $callback = $functionName;
    }
    //make sure the function/method is valid
    if(!is_callable($callback, false, $callableName)) {
      throw new Exception("$callableName is not callable " ."as a parameter to onload");
      return false;
    }
    $this->_onload = $callback;
    //var_dump($this->_onload);
  }


  /**
  * Check to see if a callback has been defined and if so,
  * whether or not it has already been called. If not,
  * invoke the callback function.
  */
  private function _checkCallback() {

    if(isset($this->_onload) && !$this->_isLoaded) {
      $this->_isLoaded = true;
      call_user_func($this->_onload, $this);
    }
  }
}
?>
