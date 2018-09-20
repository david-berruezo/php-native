<?php
require_once("class.Collection.php");
require_once("class.Course.php");
require_once("class.StudentFactory.php");
class Student {
  private $id;
  private $name;
  public $courses;
  public function __construct($id, $name) {
    $this->id = $id;
    $this->name = $name;
    $this->courses = new Collection();
    $this->courses->setLoadCallback('loadCourses', $this);
  }
  public function getName() {
    return $this->name;
  }
  public function getID() {
    return $this->id;
  }
  public function getCourses(){
    return $this->courses;
  }
  public function loadCourses(Collection $col) {
    $arCourses = StudentFactory::getCoursesForStudent($this->id, $col);
  }
  public function __toString() {
    return $this->name;
  }
}

$studentID  = 1; //use a valid studentid value from your student table
$objStudent = NULL;
try {
  $objStudent = StudentFactory::getStudent($studentID);
} catch (Exception $e) {
  die("Student #$studentID doesn’t exist in the database!");
}
$objStudent->getCourses()->length();
//var_dump($objStudent->getCourses());
//var_dump($objStudent->getCourses()->getItem('CS101'));
//var_dump($objStudent->getCourses()->getItems());

foreach($objStudent->getCourses()->getItems() as $objCourse) {
  var_dump($objCourse);
  $id = $objCourse->getId();
  echo("id es: ".$id);
  //var_dump($key);
  //print $objStudent . " is currently enrolled in " . $objCourse . "<br>\n";
}

?>