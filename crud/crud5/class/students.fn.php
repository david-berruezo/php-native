<?php
include_once ('students.core.php');
/**
 * student fn
 * 
 * @package crud
 * @author tovarj4
 * @copyright 2016
 * @version $Id$
 * @access public
 */
$_student = new student();
if (isset($_POST['action']))
{
    if ($_POST['action'] == 0)
    { //All Students
        $arrStudents = $_student->getAll();
        $len = count($arrStudents);
        $tr = "";

        for ($i = 0; $i < $len; $i++)
        {

            if ($i % 2 == 0)
            {
                $tr .= "<tr class='active'>";
            } else
            {
                $tr .= "<tr class='success'>";
            }

            $tr .= "<td>" . $arrStudents[$i]['id_student'] . "</td>";
            $tr .= "<td>" . $arrStudents[$i]['student_name'] . "</td>";
            $tr .= "<td>" . $arrStudents[$i]['student_age'] . "</td>";
            $tr .= "<td><a href='javascript:student.loadToEdit(" . $arrStudents[$i]['id_student'] .
                ")' class='btn btn-warning'>Edit/Delete</a></td>";
            $tr .= "</tr>";
        }

        if ($_student->error)
        {
            echo $tr;
        } else
        {
            echo " Error al consultar" . $_student->qry;
        }
    }

    if ($_POST['action'] == 1)
    { //add Student


        $student_name = $_POST['name'];
        $student_age = $_POST['age'];

        $_student->add($student_name, $student_age);

        if ($_student->error)
        {
            $arrJson = array("error" => 'true');
        } else
        {
            $arrJson = array("error" => 'false');
        }
        echo json_encode($arrJson);

    }
    if ($_POST['action'] == 2)
    { //edit Student

        $id_student = $_POST['id'];
        $student_name = $_POST['name'];
        $student_age = $_POST['age'];

        $_student->update($id_student, $student_name, $student_age);

        if ($_student->error == 'true')
        {
            $arrJson = array("error" => 'true');
        } else
        {
            $arrJson = array("error" => 'false');
        }
        echo json_encode($arrJson);


    }
    if ($_POST['action'] == 3)
    { //delete Student

        $id_student = $_POST['id'];

        $_student->delete($id_student);

        if ($_student->error == 'true')
        {
            $arrJson = array("error" => 'true', "errDesc" => $_student->qry);

        } else
        {
            $arrJson = array("error" => 'false', "errDesc" => "");
        }
        echo json_encode($arrJson);


    }
    if ($_POST['action'] == 4)
    { //get single student

        $id_student = $_POST['id'];

        $student = $_student->getSingle($id_student);

        if ($_student->error == 'true')
        {
            echo json_encode(array("error" => $_student->error, "qry" => $_student->qry));
        } else
        {

            echo json_encode($student);
        }


    }
}

/* if ($_GET['action']==4) { //get single student

$id_student = $_GET['id'];

$student = $_student->getSingle($id_student);


if($_student->error=='true'){
echo json_encode( array("error"=>$_student->error,"qry"=>$_student->qry));
} else {

echo json_encode($student);
}
}*/

?>