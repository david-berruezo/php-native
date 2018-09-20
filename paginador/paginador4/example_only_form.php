<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DBNavigator class - only Form</title>
<style type="text/css" media="screen">
	@import "style.css";
</style>
</head>
<body>
<?php

/*
EXAMPLE: how build a form for inserting (or editing) a row in a database

This example try to show major functionalities of DBNavigator class

Enjoy :)

Michele Castellucci
ghiaccio84@gmail.com
http://www.direfareprogrammare.com
*/

require("functions.inc.php");

require("HTMLForm.php");
require("HTMLPostProcessor.php");
require("PageNavigator.php");

require("TextEditorContainer.php");
require("Adv_TextArea.php");

require("DBNavigator.php");


//mysql_connect('localhost',"username","userpassword");
//mysql_select_db("dbname");

mysql_connect('localhost',"root","");
mysql_select_db("319_dfp");

//////////


$DBNUsers=new DBNavigator("
						SELECT users.id, users.name, users.surname, users.password, users.email, users.gender,
							   provinces.name AS province, provinces.region,
							   users.birth_date, users.profession, users.notes, users.curriculum, users.photo_1, users.photo_2, users.attachment								   								   
						FROM users 
								   LEFT JOIN provinces ON provinces.id=users.province_id  ");

//layout options 
$DBNUsers->setClassForFormInput('mini','mini_btn','mini_txa');
/////


//---------------TABS-----------------------------------------------------------------------
//this is the tab new feature: first param for CSS class name of he div that incorporate all the tab fields. 
//Second param for select tab link HTML code. 
//Third param (optional and only for setStandardTabLabel) for the heading of tabs 
$DBNUsers->getEditForm()->setStandardTabLabel("mainTab"
												,"<div id=\"tablink\">
													<br />Main Tab
												  </div>"
											   ,"<div style=\"float:left;color:#A77;font-weight:bold\">
													<br />This is the tab selection: &nbsp;&nbsp;
												 </div> ");

$DBNUsers->getEditForm()->addTab("tab1","<div id=\"tablink\">
											<br />Tab 1
										 </div> ",array("photo_1","photo_2","attachment"));

$DBNUsers->getEditForm()->addTab("tab2","<div id=\"tablink\">
											<br />Tab 2
										 </div> ",array("notes","curriculum"));	
//------------------------------------------------------------------------------------------------------------

$DBNUsers->setPrimaryTable("users");
$DBNUsers->setLanguage('english');
$DBNUsers->setDateInterval(date('Y')-90,date('Y'));

$DBNUsers->setHTMLTextareaParams(array('filesPath'=>".",
									   'fontSize'=>true,
									   'selectFont'=>true));

$DBNUsers->setPhotoField(array('photo_1','photo_2'),100,true);
$DBNUsers->setPasswordField("password");
$DBNUsers->setFileField("attachment");
$DBNUsers->setMailField("email");
$DBNUsers->setFilePath("."); 
$DBNUsers->setFileNameCriteria("*tb*_*pk*_*cn*.*ext*"); //The default: tableName_keyNumber_fieldName.ext (EX: users_4_attachment.jpg)




$DBNUsers->setFormHeading("<em style=\"font-size:18px;color:#D11\">Please fill this form for registration</em>");

//customiziong the form..
$DBNUsers->getEditForm()->addInput("hidden","inserting_date",date("Y-m-d H:i:s"));
$DBNUsers->getEditForm()->addVerificationCode("Write what you see..",'mini',"This is a <strong>CAPTCHA</strong> system..for security");


function emailNotification() 
{
	mail("ghiaccio84@gmail.com","New user registration"
		,"User named <strong>{$_POST['name']} {$_POST['surname']}</strong> has been registered"
		,"Content-Type: text/html; charset=utf-8");
}


//after you see the example, try to use an existent id number as first argument of this function
$DBNUsers->go_only_for_form('here a non existent id value for a record insertion'
							,"<h1>You have been successfully inserted in the Database !</h1><a href=\"{$_SERVER['PHP_SELF']}\">Want to insert another one!??</a>"
							,'emailNotification');

?>
</body>
</html>