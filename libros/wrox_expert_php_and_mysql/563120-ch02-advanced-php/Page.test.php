<?php

include('Page.class.php');
include('BookList.class.php');

$dbConn = new mysqli('localhost', 'root', null, 'bookclub');

$booksPerPage = 3;
$page = 2;

$bookList = new BookList($dbConn);
$bookList->booksPerPage = $booksPerPage;

$bookPage = new Page($bookList, $page, $booksPerPage);

foreach( $bookPage as $key => $book ) {
  echo "$key = ";
  print_r($book);
}

?>
