<?php
require_once('class.Collection.php');

class CourseCollection extends Collection {
  public function addItem(Course $obj, $key = null) {
    parent::addItem($obj, $key);
  }
}
?>