<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 24/06/2016
 * Time: 13:17
 */
class MetodosMagicos{

    private $variable1      = 'soy la variable 1';
    private $propertyTable  = array();

    public function __construct() {
        echo ('Bienvenido a metodos magicos');
    }

    public function __destruct() {
        echo ('Destruimos objeto');
    }

    public function getVariable1() {
        return $this->variable1;
    }

    public function setVariable1($variable1) {
       $this->variable1 = $variable1;
    }

    public function __get($propertyName){
        if(!array_key_exists($propertyName, $this->propertyTable)) {
            throw new Exception("Invalid property \"$propertyName\"! ");
        }
        if(method_exists($this, 'get' . $propertyName)) {
            return call_user_func(array($this, 'get' . $propertyName));
        } else {
            return $this->data[$this->propertyTable[$propertyName]];
        }
    }

    public function __set($propertyName, $value) {
        if(!array_key_exists($propertyName, $this->propertyTable)) {
            throw new Exception("Invalid property \"$propertyName\"!");
        }
        if(method_exists($this, 'set' . $propertyName)) {
            return call_user_func(array($this, 'set' . $propertyName),$value);
        } else {
            // If the value of the property really has changed
            // and it's not already in the changedProperties array,
            // add it.
            if($this->propertyTable[$propertyName] != $value &&
                !in_array($propertyName, $this->changedProperties)) {
                $this->changedProperties[] = $propertyName;
            }
            //Now set the new value
            $this->data[$this->propertyTable[$propertyName]] = $value;
        }
    }

}

