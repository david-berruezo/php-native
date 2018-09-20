<?php
include_once ('core/db.inc');
/**
 * student
 * 
 * @package crud
 * @author tovarj4
 * @copyright 2016
 * @version $Id$
 * @access public
 */
class student
{
    var $error = false;
    protected $connection;
    var $qry = "sin query";
    /**
     * student::mysqlLink()
     * 
     * @return
     */
    private function mysqlLink()
    {
        @$connection = new PDO('mysql:host=' . SERVER . ';dbname=' . DB, DB_USER,
            DB_PASSWORD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }

    /**
     * student::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->connection = $this->mysqlLink();
        $this->error = 'false';
    }

    /**
     * student::add()
     * 
     * @param mixed $student_name
     * @param mixed $student_age
     * @return
     */
    public function add($student_name, $student_age)
    {
        try {
            $this->error = 'false';
            $conn = $this->connection;
            $sql = "INSERT into " . STUDENTS_TABLE .
                " (student_name,student_age)VALUES( :student_name,:student_age);";
            $q = $conn->prepare($sql);
            $q->execute(array(':student_name' => $student_name, ':student_age' => $student_age));

            $this->error = 'false';
        }
        catch (PDOException $e) {

            $this->error = 'true';

            echo "ERROR: " . $e->getMessage();


        }
    }

    /**
     * student::update()
     * 
     * @param mixed $id_student
     * @param mixed $student_name
     * @param mixed $student_age
     * @return
     */
    public function update($id_student, $student_name, $student_age)
    {
        try {
            $this->error = 'false';
            $conn = $this->connection;
            $sql = "UPDATE " . STUDENTS_TABLE .
                " SET student_name = :student_name,student_age =:student_age WHERE id_student =:id_student;";
            $q = $conn->prepare($sql);
            $q->execute(array(
                ':student_name' => $student_name,
                ':student_age' => $student_age,
                ':id_student' => $id_student));

            $this->error = 'false';
        }
        catch (PDOException $e) {

            $this->error = 'true';

            echo "ERROR: " . $e->getMessage();


        }
    }

    /**
     * student::delete()
     * 
     * @param mixed $id_student
     * @return
     */
    public function delete($id_student)
    {
        try {
            $this->error = 'false';
            $conn = $this->connection;
            $sql = "DELETE FROM " . STUDENTS_TABLE . " WHERE id_student = " . $id_student;
            $q = $conn->prepare($sql);
            $q->execute();

            $this->qry = $sql;
            $this->error = 'false';
        }
        catch (PDOException $e) {

            $this->error = 'true';
            $this->qry = $e->getMessage();


        }
    }

    /**
     * student::getAll()
     * 
     * @return
     */
    public function getAll()
    {
        try {
            $conn = $this->connection;
            $sql = "SELECT id_student,student_name,student_age";
            $sql .= " FROM " . STUDENTS_TABLE . " ORDER BY student_name;";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($array);
            $this->qry = $sql;
            $this->error = 'false';

            return $array;
        }
        catch (PDOException $e) {
            $this->error = 'true';
            echo "ERROR: " . $e->getMessage();
        }
    }

    /**
     * student::getSingle()
     * 
     * @param mixed $id_student
     * @return
     */
    public function getSingle($id_student)
    {
        try {
            $this->error = 'false';
            $conn = $this->connection;
            $sql = "SELECT id_student,student_name,student_age";
            $sql .= " FROM " . STUDENTS_TABLE . " WHERE id_student =$id_student ;";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->qry = $sql;
            $this->error = 'false';

            return $array;
        }
        catch (PDOException $e) {

            echo "ERROR: " . $e->getMessage();
        }
    }
}
?>