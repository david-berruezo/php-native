<?php
	//$connect =  mysql_connect('localhost', '', '');
	//mysql_set_charset('utf8', $connect);
	$connect = new mysqli("localhost", "root", "Berruezin23");
	mysqli_set_charset($connect,"utf8");	
?>