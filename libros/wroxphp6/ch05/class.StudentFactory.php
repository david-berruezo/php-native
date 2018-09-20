<?php
include_once "database.php";
class StudentFactory {
  // object vars
  private static $table_name     = "student";
  /*
   * Deuelve un estudiante por id
   */
  public static function getStudent($id) {
    $db    = DB::getInstance()->getConnection();
    $query = 'SELECT * FROM student where studentid = ?';
    $stmt  = $db->prepare( $query );
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $data  = $stmt->fetch(PDO::FETCH_ASSOC);
    if(is_array($data) && sizeof($data)) {
      // echo ("id: ".$data['studentid']." nombre: ".$data['name']);
      // var_dump($objeto);
      $objeto = new Student($data['studentid'], $data['name']);
      return $objeto;
    } else {
      throw new Exception("Student $id does not exist.");
    }
  }

  /*
   * Devuelve todos los cursos
   * por id de estudiante
   */
  public static function getCoursesForStudent($id, $col) {
    $id = 1;
    $db = DB::getInstance()->getConnection();
    $query = 'select st.studentid,st.name,c.courseid,c.coursecode,c.name as coursename,stc.studentid as coursestudentid,stc.courseid as coursecourseid ';
    $query.= 'from student as st ';
    $query.= 'left join studentcourse as stc ';
    $query.= 'on (st.studentid = stc.studentid) ';
    $query.= 'left join course as c ';
    $query.= 'on (c.courseid = stc.courseid) ';
    $query.= 'where stc.studentid = 1 ';
    $stmt  = $db->prepare( $query );
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    //$data  = $stmt->fetch(PDO::FETCH_ASSOC);
    $data  = $stmt->fetchAll();
    //var_dump($data);
    if(is_array($data) && sizeof($data)) {
      foreach($data as $datum) {
        //var_dump($datum);
        //echo ('courseid: '.$datum['courseid'].'coursecode: '. $datum['coursecode'].'coursename: '.$datum['coursename'].'<br>');
        //echo("<br><br>");
        $objCourse = new Course($datum['courseid'], $datum['coursecode'],$datum['coursename']);
        $col->addItem($objCourse, $objCourse->getCourseCode());
      }
    }

  }

  /*
   * Debuelve todos los estudiantes
   */
  public static function getStudents(){
    $db    = DB::getInstance()->getConnection();
    $query = "SELECT * FROM " .self::$table_name;
    $stmt  = $db->prepare( $query );
    $stmt->execute();
    // get retrieved row
    //$data  = $stmt->fetch(PDO::FETCH_ASSOC);
    return $stmt;
  }
}
?>


