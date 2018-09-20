<?php
/**
 * @author: Pierre Delporte - pierre.delporte@alf-solution.be
 * Date: 1/02/15
 * Time: 13:17
 * @note : No warranty is given on the following code.
 * 
 * This code is given as an example.
 * to be able to run the below example you should create the following database and table
 * 
CREATE SCHEMA `framework` ;
CREATE TABLE `employee` (
`id` int NOT NULL AUTO_INCREMENT,
`first_name` varchar(100) NOT NULL,
`last_name` varchar(100) NOT NULL,
`job_title` varchar(100) DEFAULT NULL,
`salary` double DEFAULT NULL,
`notes` text,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `employee` (`first_name`, `last_name`, `job_title`, `salary`) VALUES
('Robin', 'Jackman', 'Software Engineer', 5500),
('Taylor', 'Edward', 'Software Architect', 7200),
('Vivian', 'Dickens', 'Database Administrator', 6000),
('Harry', 'Clifford', 'Database Administrator', 6800),
('Eliza', 'Clifford', 'Software Engineer', 4750),
('Nancy', 'Newman', 'Software Engineer', 5100),
('Melinda', 'Clifford', 'Project Manager', 8500),
('Harley', 'Gilbert', 'Software Architect', 8000);
 *
 */
/* Include constant to define parameters to connect to the DB */
include_once './includes/global.php';

/* Include all the classes */
include_once "./db/DB.php";
include_once "./db/Table.php";
include_once "./db/data.php";
include_once "./db/TableRow.php";

$dblink = DB::getInstance(HOST, USER, PASSWORD, DBNAME, TYPEDB);
if ( !$dblink->connect()){
    echo 'La connexion � la base de donn�e a �chou�e';
} else {
    echo 'Connexion r�ussie';
}
echo '<hr>';
/* Search employee with ID = 1 */
$employee = Table::FetchById('employee', 1);
/* display the field name First_name */
echo $employee->First_name;

/*
This will return:
Robin
*/
echo '<hr>';
/* display the value of field at position 1 */
echo $employee->get(1);
/*
This will return:

Robin
*/
echo '<hr>';
/* Load all rows from table employees */
$employees = Table::Fetch('employee');
/* Display the first and last name of all employees */
foreach ($employees as $employee){
    echo $employee->First_name.' '.$employee->Last_name.'<br>';
}
/*
This will return:

Robin Jackman
Taylor Edward
Vivian Dickens
Harry Clifford
Eliza Clifford
Nancy Newman
Melinda Clifford
Harley Gilbert
*/
echo '<hr>';
/* Search all employees with a salary > 6000$ */
$employees = Table::Fetch('employee', 'where salary > 6000');

foreach ($employees as $employee){
    echo $employee->First_name.' '.$employee->Last_name.'<br>';
}
/*
This will return:

Taylor Edward
Harry Clifford
Melinda Clifford
Harley Gilbert
*/
echo '<hr>';
/* Search employees based on a TableRow definition */
$data = new TableRow('employee');
$data->Last_name = 'Clifford';
$employees = $data->find();
foreach ($employees as $employee){
    echo $employee->First_name.' '.$employee->Last_name;
    echo '<br>';
}
/*
This will return:

Harry Clifford
Eliza Clifford
Melinda Clifford
*/
echo '<hr>';
/* Sepcify ohter operator with TableRow to get records */
$data = new TableRow('employee');
$data->set('Salary', 7000, '>');
$employees = $data->find();
foreach ($employees as $employee){
    echo $employee->First_name.' '.$employee->Last_name.' '.$employee->Salary;
    echo '<br>';
}
/*
This will return:

Taylor Edward 7200
Melinda Clifford 8500
Harley Gilbert 8000
*/
echo '<hr>';
/* Get record based on an SQL select statement */
$employees = Table::Select("select * from employee where salary BETWEEN 6000 and 7500");
foreach ($employees as $employee){
    echo $employee->First_name.' '.$employee->Last_name.' '.$employee->Salary;
    echo '<br>';
}

/*
This will return:

Taylor Edward 7200
Vivian Dickens 6000
Harry Clifford 6800
*/
echo '<hr>';
/* Insert a new record into the table employee */
$data = new TableRow('employee');
$data->Id = 0; /* mandatory to set to 0 */
$data->Last_name = 'Doe';
$data->First_name = 'John';
$data->Salary = 7500;
$data->Job_title = 'IT Manager';
if (($newId = $data->save()) !== false){
    echo "A new record has been successfully inserted with the ID $newId";
} else {
    echo "An error occures while trying to insert a new record";
}

/*
Thiw will return:

A new record has been successfully inserted with the ID 9
*/
echo '<hr>';
/* Check that the record has been successfully inserted by displaying all columns of all the records*/
$employees = Table::Fetch('employee');
echo "number of rows : ".$employees->count().'<hr>';
foreach ($employees as $employee){
    echo "Number of columns : ".$employee->count().'<br>';
    foreach ($employee->array_value as $field => $value){
        echo ''.$field.' = '.$value. ' ';
    }
    echo '<br>';
}
/*
This will return

number of rows : 9
-----------------------
Number of columns : 6
Id = 1 First_name = Robin Last_name = Jackman Job_title = Software Engineer Salary = 5500 Notes =
Number of columns : 6
Id = 2 First_name = Taylor Last_name = Edward Job_title = Software Architect Salary = 7200 Notes =
Number of columns : 6
Id = 3 First_name = Vivian Last_name = Dickens Job_title = Database Administrator Salary = 6000 Notes =
Number of columns : 6
Id = 4 First_name = Harry Last_name = Clifford Job_title = Database Administrator Salary = 6800 Notes =
Number of columns : 6
Id = 5 First_name = Eliza Last_name = Clifford Job_title = Software Engineer Salary = 4750 Notes =
Number of columns: 6
Id = 6 First_name = Nancy Last_name = Newman Job_title = Software Engineer Salary = 5100 Notes =
Number of columns : 6
Id = 7 First_name = Melinda Last_name = Clifford Job_title = Project Manager Salary = 8500 Notes =
Number of columns : 6
Id = 8 First_name = Harley Last_name = Gilbert Job_title = Software Architect Salary = 8000 Notes =
Number of columns: 6
Id = 9 First_name = John Last_name = Doe Job_title = IT Manager Salary = 7500 Notes
*/
echo '<hr>';

/* Update the salary of the record with ID = $newId */
$data = new TableRow('employee');
$data->Id = $newId;
$data->Salary = 8000;
if ( $data->save() !== false){
    echo "The record has been successfully updated";
} else {
    echo "An error occurs while updating the record";
}
/* Display the updated record */
echo '<hr>';
$employee = Table::FetchById('employee', $newId);
echo "Number of columns : ".$employee->count().'<br>';
foreach ($employee->array_value as $field => $value){
    echo ''.$field.' = '.$value. ' ';
}
echo '<hr>';

/*
This will return:

The record has been successfully updated
Number of columns : 6
Id = 9 First_name = John Last_name = Doe Job_title = IT Manager Salary = 8000 Notes
*/

/* Search for record with ID = $newId and update the salary to $8500 */
$data = Table::FetchById('employee', $newId);
$data->Salary = 8500;
if ( $data->save() !== false){
    echo "The record has been successfully updated";
} else {
    echo "An error occurs while updating the record";
}
/* Display the updated record */
echo '<hr>';
$employee = Table::FetchById('employee', $newId);
echo "Number of columns : ".$employee->count().'<br>';
foreach ($employee->array_value as $field => $value){
    echo ''.$field.' = '.$value. ' ';
}
echo '<hr>';
/*
This will return:

The record has been successfully updated
Number of columns : 6
Id = 9 First_name = John Last_name = Doe Job_title = IT Manager Salary = 8500 Notes
*/

/* use sql statementn to update a record */
$nbRecordUpdated = Table::Execute("UPDATE `employee` set `salary` = 9000 where `id` = $newId");
echo "$nbRecordUpdated record(s) has (have) been updated";

echo '<hr>';
$employee = Table::FetchById('employee', $newId);
echo "Number of columns : ".$employee->count().'<br>';
foreach ($employee->array_value as $field => $value){
    echo ''.$field.' = '.$value. ' ';
}
echo '<hr>';
/*
This will return:

1 record(s) has (have) been updated
Number of columns : 6
Id = 9 First_name = John Last_name = Doe Job_title = IT Manager Salary = 9000 Notes
*/

/* Delete the record with ID = $newId */
if (Table::DeleteById('employee', $newId)){
    echo "The record has been deleted";
}
/*
This will return:

The record has been deleted
*/

/* walk trough the table employee and delete the record where salary is greated than $7500 */
$employees = Table::Fetch('employee');
foreach ($employees as $employee){
    if ($employee->Salary > 7500){
        $employee->delete();
    };
}