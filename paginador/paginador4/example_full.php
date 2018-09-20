<?php 
	ob_start(); //necessary when php.ini output_buffering setting on server is OFF (ajax function need it to clean buffer)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DBNavigator class - Full Example</title>
<style type="text/css" media="screen">
	@import "style.css";
</style>
</head>
<body>
<?php

/*
EXAMPLE: how build a simple users management in an E-Commerce system

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

if (isset($_GET['empty_cart'])) //empty an user cart
{
	mysql_query("DELETE FROM cart WHERE user_id='{$_GET['empty_cart']}'")	or die ("Error on emptying cart: <br />".mysql_error());
	unset($_GET['empty_cart']);
}

$function='';
function customViewResult($result)
{
	global $DBNUsers;

	$return="<strong>Welcome to the custom result viewing!!!</strong>";
	while ($row=mysql_fetch_row($result))
	{
		$return.='<div style="float:left;margin:5px;border:1px solid #00F;padding:3px">';
		
		for ($i=0;isset($row[$i]);$i++) {$return.=$row[$i].'<br />';}
		
		$return.=$DBNUsers->getEditLink($row[0]).'&nbsp;&nbsp;&nbsp;'.$DBNUsers->getDeleteLink($row[0]).'</div>';
	}
	return $return.'<div style="clear:both"></div>';
}
//  $function='customViewResult';  //AFTER YOU EXAMINE THIS EXAMPLE, TRY TO ACTIVATE THIS LINE OF CODE



///first, create Cart Object because it will be passes to setDeleteRecursive() method of Users Object, if it is non used for manage datas	
$DBNCart=new DBNavigator(" SELECT cart.id, users.inserting_date, products.name, cart.quantity, products.price, (cart.quantity * products.price) AS row_price 
							 FROM cart 
										INNER JOIN users ON users.id=cart.user_id 
										INNER JOIN products ON products.id=cart.product_id
							  			".(isset($_GET['user_id'])?" WHERE cart.user_id='{$_GET['user_id']}'":'')." ");
	

$DBNCart->setTableStyle('TD','TD','headerTD'); 
$DBNCart->setClassForFormInput('mini','mini_btn','mini_txa');

$DBNCart->setTableCellSpacing(3);

$DBNCart->setPrimaryTable("cart");
$DBNCart->showAllElements(true);
$DBNCart->setDefaultOrd("inserting_date");

$DBNCart->setRowName("product"); 
$DBNCart->setLanguage('english');
$DBNCart->hidePrimaryKey(true);

$DBNCart->canEdit(true);
$DBNCart->canDelete(true);
$DBNCart->canInsert(true);
$DBNCart->canExport(true);
$DBNCart->canMultipleEditDelete(true);
$DBNCart->useAjax(true);
	

if ($DBNCart->status()=='inserting')	
	$DBNCart->getEditForm()->addInput("hidden","inserting_date",date("Y-m-d H:i:s"));
else 
	$DBNCart->removeInput("inserting_date");

if (isset($_GET['user_id']))
	$DBNCart->getEditForm()->addInput("hidden","user_id",$_GET['user_id']);

/////////////////////////////////////////////	
	

if (!isset($_GET['user_id']))
{

	$DBNUsers=new DBNavigator("
							SELECT users.id ,users.inserting_date, users.name, users.surname, users.password, users.email, users.gender,
								   provinces.name AS province, provinces.region,
								   users.birth_date, users.profession, users.notes, users.curriculum, users.photo_1, users.photo_2, users.attachment,								   
								   count(products.id) AS items, sum(cart.quantity * products.price) AS total_price
								   
							FROM users 
									   LEFT JOIN provinces ON provinces.id=users.province_id
									   LEFT JOIN cart ON cart.user_id=users.id
							           LEFT JOIN products ON products.id=cart.product_id
									   
							GROUP BY users.id	   
						");



	$DBNUsers->setDateInterval(date('Y')-90,date('Y'));
	
	//layout options 
	$DBNUsers->setTableStyle('TD','TD','headerTD'); 
	$DBNUsers->setClassForFormInput('mini','mini_btn','mini_txa');

	$DBNUsers->setTableCellSpacing(3);
    /////
	
	$DBNUsers->setPrimaryTable("users");
	$DBNUsers->setResultsPerPage(5);
	$DBNUsers->setDefaultOrd("inserting_date DESC");

	$DBNUsers->setRowName("user"); 
	$DBNUsers->setLanguage('english');
	$DBNUsers->hidePrimaryKey(true);
	
	
	$DBNUsers->setDeleteRecursive('',$DBNCart,"Are you sure? This will delete also user cart!"); ///Here we use Cart
	
	$DBNUsers->addDataCol("Products list","SELECT products.name 
											 FROM cart 
									                   INNER JOIN products ON products.id = cart.product_id 
											WHERE cart.user_id='%current_row_id%'",'LINKED_RECORDS');
											
	$DBNUsers->addLinkCol('Empty cart','empty_cart',"delete.png",true,false,false,"{{{items}}}>0");
	$DBNUsers->addLinkCol('Edit cart','user_id',"detail.gif"    ,true,false,false,false            ,array('items','total_price'));
	
	
	$DBNUsers->setFieldStatusIndicator('attachment','full.gif','empty.gif');
 	$DBNUsers->addSwitchCol  ('gender', 'male.gif','female.gif'); 
			
	$DBNUsers->canEdit(true);
	$DBNUsers->canDelete(true);
	$DBNUsers->canInsert(true);
	$DBNUsers->canExport(true);
	$DBNUsers->canMultipleEditDelete(true);
	$DBNUsers->useAjax(true);
	
	$DBNUsers->setHTMLTextareaParams(array('filesPath'=>".",
									   		'fontSize'=>true,
									   		'selectFont'=>true));
	
	
	$DBNUsers->canViewForPrint(true);
	
	
	
	
	$DBNUsers->setImageField(array('photo_1','photo_2'),100,true);
	$DBNUsers->setPasswordField("password");
	$DBNUsers->setFileField("attachment");
	$DBNUsers->setMailField("email");
	
	$DBNUsers->setSearchField("users.gender");
	$DBNUsers->setSearchField("provinces.name");
	$DBNUsers->setSearchField("provinces.region");
	$DBNUsers->setSearchField("users.name",'',"users.surname",'');
	
	$DBNUsers->setFileNameCriteria("*tb*_*pk*_*cn*.*ext*"); //The default: tableName_keyNumber_fieldName.ext (EX: users_4_attachment.jpg)
	$DBNUsers->setFilePath("."); 
	
	
	$DBNUsers->removeDisplaying('birth_date','profession','notes','curriculum','photo_2');
	
	if ($DBNUsers->status()=='inserting')	
		$DBNUsers->getEditForm()->addInput("hidden","inserting_date",date("Y-m-d H:i:s"));
	else 
		$DBNUsers->removeInput("inserting_date");

	echo $DBNUsers->printAddRowButton()." &nbsp;&nbsp;&nbsp;&nbsp; ";
	echo $DBNUsers->printExcelXmlDownloadButton()." &nbsp;&nbsp;&nbsp;&nbsp; "; 
	echo $DBNUsers->printCsvDownloadButton(). "<br /><br />";


	$DBNUsers->go(false,false,$function);

}
else
{
	$user=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='{$_GET['user_id']}'"));

	echo "This is the shopping cart of <strong>".$user['name']." ".$user['surname']."</strong><br /><br />
	<a href=\"{$_SERVER['PHP_SELF']}?".buildQueryString('user_id')."\">BACK TO USERS</a><br /><br />";

	echo $DBNCart->printAddRowButton()." &nbsp;&nbsp;&nbsp;&nbsp; ";
	echo $DBNCart->printExcelXmlDownloadButton()." &nbsp;&nbsp;&nbsp;&nbsp; "; 
	echo $DBNCart->printCsvDownloadButton(). "<br /><br />";


	$DBNCart->go();
}

?>
</body>
</html>