<?php

include('BookList.class.php');
$dbConn = new mysqli('localhost', 'root', null, 'bookclub');

$booksPerPage = 3;

$bookList = new BookList($dbConn);
$bookList->booksPerPage = $booksPerPage;

foreach ( $bookList as $key => $book ) {
  echo "$key = ";
  print_r($book);
}

?>
