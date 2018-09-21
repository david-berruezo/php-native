<?php
/**
  PHPCollection example script
*/
/* Include */
require 'base.class.php';
require 'collection.class.php';

/* Create an example object */
class ExampleObject extends Base {
  var $name;
  
  function ExampleObject($s) {
    $this->name=$s;
  }
  
  function setName($s) {
    $this->name=$s;
  }
  
  function getName() {
    return $this->name;
  }
}

/* collection */
$coll=new Collection();

/* add to collection class */
$coll->add(new ExampleObject("Tanveer"));
$coll->add(new ExampleObject("Hasan"));

/* Iterate */
$it=$coll->iterator();

/* retrive object */
while($it->hasNext()) {
  $obj=$it->next();
  echo "<b>Name: </b>".$obj->getName()."<br />";
}

/**********************************************************
 **             Without declaring Object                 **
 **                                                      **
 **********************************************************/
 $coll2=new Collection();
 
 $coll2->add("My first String");
 $coll2->add("My second string");
 
 /* iterator */
 $it=$coll2->iterator();
 
 /* fetch */
 while($it->hasNext()) {
   $obj=$it->next();
   echo "<b>String: </b>".$obj->getValue()."<br />";
 }

?>
