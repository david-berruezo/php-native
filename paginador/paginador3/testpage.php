<?php
error_reporting(E_ALL);
include('ajaxpaginator.class.php');
// instantiate mysqli connection
$conn = new mysqli('localhost', 'root', 'Berruezin23','paginator3') ;
$query = "SELECT * FROM customers";
$recordsPerPage = 5;//number of records per page
// page number, records per page, sql query, and the mysqli connection object
$paginator 		  = new AjaxPaginator('1',$recordsPerPage,$query,$conn);
$paginator->debug = true;
try{
	$rows = $paginator->paginate();
}catch (Exception $e){
	echo $e->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.paginate.js"></script>
	<script type="text/javascript">
	$(document).ready (function () {
		$('#srch_btn').click(function () {
			$('#listing_container').Paginate();
			return false;
		});

		$('.paginator a').click(function () {
			$('#listing_container').Paginate(this.id);
			return false;
		});
	});
	</script>
</head>
<body>
<div id="wrapper">
<div id='search-box' class="search-box">
<form action="" method="get">
<input id="search" type="text" class="search" />
<?php 
$getArray = array();
parse_str($_SERVER['QUERY_STRING'],$getArray);
foreach($getArray as $key=>$value){
	echo "<input type='hidden' name='{$key}' id='{$key}' value='{$value}' />";
}
?>
<input id="srch_btn" type="submit" value="search" class="button" />
</form>
</div>
<br class="clear" />
<div id="listing_container">
	<table border="0" cellpadding="2" cellspacing="0" class="listing">
	<tr>
		<th nowrap="nowrap" width="40"> ID</th>
		<th nowrap="nowrap" width="450" align='left'>Name</th>
	</tr>
<?php
foreach($rows as $row){
	echo "<tr>";
	echo "<td nowrap='nowrap' align='center'>{$row['id']}</td>";
	echo "<td nowrap='nowrap' align='left'>{$row['name']}</td>";
	echo "</tr>";
}
echo "</table><br />";
$links = $paginator->getLinks ();
echo "<div class='paginator'> " . $links ;
echo "<p>Page " . $paginator->pageId . " of " . $paginator->totalPages . "</p>";
?>
</div> 
</div>
</div>
</body>
</html>
			