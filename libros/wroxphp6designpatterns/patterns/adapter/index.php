<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 31/08/2016
 * Time: 9:33
 */
require_once "vendor/autoload.php";
/** create the new 404 error object **/
$error = new errorObject("404:Not Found");
/** write the error to the console **/
$log = new logToConsole($error);
$log->write();

/** create the new 404 error object adapted for csv **/
$errorCsv = new logToCSVdapter("404:Not Found");
/** write the error to the csv file **/
$log = new logToCSV($errorCsv);
$log->write();
?>