<?php
error_reporting(E_ALL);

include('ajaxpaginator.class.php');

// instantiate mysqli connection
// CHANGE THESE SETTINGS
$conn = new mysqli('localhost', 'root', 'Berruezin23','paginator3') ;
$recPerPage = 5;//number of records per page

$query = "SELECT * FROM customers ";

// if there is a a search query
$searchQuery = !empty($_GET['search'])?$searchQuery = $_GET['search']:''; 
$pageId= empty($_GET['page'])? 1:$conn->real_escape_string($_GET['page']); 


$paginator = new AjaxPaginator($pageId,$recPerPage,$query,$conn);

$paginator->searchQuery = $searchQuery;

// database field to search in
//$pagination->fields = 'name';
// or try array
// passing an array makes the search text to search in the name or the id
$paginator->fields = array('name','id');

// Get the paginated rows
try{
	$rows = $paginator->paginate();
}catch (Exception $e){
	echo $e->getMessage();
}

?>
<script type="text/javascript">
	$('.paginator a').click(function () {
		$('#listing_container').Paginate(this.id);
		return false;	
	});
</script>

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

echo "<div class='paginator'> " . $paginator->getLinks () ;

echo "<br /><p>Page " . $paginator->pageId . "  of " . $paginator->totalPages."</p>". "</div>";
