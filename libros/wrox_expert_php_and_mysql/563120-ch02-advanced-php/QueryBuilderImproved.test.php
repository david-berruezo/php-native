<?php

include('QueryBuilderImproved.class.php');

// Example usage
$builder = new QueryBuilderImproved();
$deleteBook = $builder->getQueryObject("DELETE FROM {books} WHERE id=%d");

echo $deleteBook( $_GET['id'] )."\n";

?>
