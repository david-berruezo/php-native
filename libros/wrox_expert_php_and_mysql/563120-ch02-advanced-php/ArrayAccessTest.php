<?php

include('tested/BookList.class.php');

$dbConn = new mysqli('localhost', 'root', null, 'bookclub');

$booksPerPage = 3;

$bookList = new BookList($dbConn);
$bookList->booksPerPage = $booksPerPage;

print_r($bookList[3]);
?>
